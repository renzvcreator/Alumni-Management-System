<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $me = $request->user();

        $announcements = Announcement::with('admin')->latest()->take(5)->get();

        $upcomingEvents = Event::active()
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        if ($upcomingEvents->isEmpty()) {
            $upcomingEvents = Event::active()
                ->orderByDesc('event_date')
                ->take(5)
                ->get();
        }

        $rsvpEventIds = $me->events()->pluck('events.id')->all();

        $stats = [
            'alumni'    => User::where('role', 'alumni')->where('status', 'approved')->count(),
            'rsvps'     => $me->events()->count(),
            'likes'     => \App\Models\ProfileLike::where('user_id', $me->id)->count(),
            'bookmarks' => \App\Models\ProfileBookmark::where('user_id', $me->id)->count(),
        ];

        $featuredAlumni = User::where('role', 'alumni')
            ->where('status', 'approved')
            ->where('id', '!=', $me->id)
            ->whereHas('profile')
            ->with('profile')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $unreadMessages = \App\Models\Message::where('recipient_id', $me->id)
            ->whereNull('read_at')
            ->count();

        return view('dashboard', compact(
            'announcements', 'upcomingEvents', 'rsvpEventIds',
            'stats', 'featuredAlumni', 'unreadMessages', 'me'
        ));
    }
}
