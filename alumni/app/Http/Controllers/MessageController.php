<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $me = $request->user();

        $threads = Message::query()
            ->selectRaw('
                CASE WHEN sender_id = ? THEN recipient_id ELSE sender_id END AS partner_id,
                MAX(created_at) AS last_at,
                MAX(id) AS last_id
            ', [$me->id])
            ->where(function ($q) use ($me) {
                $q->where('sender_id', $me->id)->orWhere('recipient_id', $me->id);
            })
            ->groupBy('partner_id')
            ->orderByDesc('last_at')
            ->get();

        $partnerIds = $threads->pluck('partner_id')->all();
        $partners = User::with('profile')->whereIn('id', $partnerIds)->get()->keyBy('id');

        $lastMessages = Message::whereIn('id', $threads->pluck('last_id'))->get()->keyBy('id');

        $unreadCounts = Message::where('recipient_id', $me->id)
            ->whereNull('read_at')
            ->whereIn('sender_id', $partnerIds)
            ->selectRaw('sender_id, COUNT(*) as c')
            ->groupBy('sender_id')
            ->pluck('c', 'sender_id');

        return view('messages.index', compact('threads', 'partners', 'lastMessages', 'unreadCounts'));
    }

    public function show(Request $request, User $user): View
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 404);
        abort_unless($user->isApproved() && $user->isAlumni() || $user->isAdmin(), 404);

        Message::where('sender_id', $user->id)
            ->where('recipient_id', $me->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($me, $user) {
            $q->where('sender_id', $me->id)->where('recipient_id', $user->id);
        })->orWhere(function ($q) use ($me, $user) {
            $q->where('sender_id', $user->id)->where('recipient_id', $me->id);
        })->orderBy('created_at')->get();

        $partner = $user->load('profile');

        return view('messages.show', compact('messages', 'partner'));
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 404);
        abort_unless(($user->isApproved() && $user->isAlumni()) || $user->isAdmin(), 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($me, $user, $data) {
            Message::create([
                'sender_id' => $me->id,
                'recipient_id' => $user->id,
                'body' => $data['body'],
            ]);

            AppNotification::notify(
                $user->id,
                'message',
                "New message from {$me->name}",
                \Illuminate\Support\Str::limit($data['body'], 80),
                route('messages.show', $me)
            );
        });

        return redirect()->route('messages.show', $user);
    }
}
