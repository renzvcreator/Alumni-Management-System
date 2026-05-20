<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Poke;
use App\Models\ProfileBookmark;
use App\Models\ProfileLike;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileInteractionController extends Controller
{
    public function toggleLike(Request $request, User $user): RedirectResponse
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 403);

        $existing = ProfileLike::where('user_id', $me->id)
            ->where('target_user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status', 'Like removed.');
        }

        ProfileLike::create(['user_id' => $me->id, 'target_user_id' => $user->id]);

        AppNotification::notify(
            $user->id,
            'like',
            "{$me->name} liked your profile",
            null,
            route('directory.show', $me)
        );

        return back()->with('status', 'Profile liked.');
    }

    public function toggleBookmark(Request $request, User $user): RedirectResponse
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 403);

        $existing = ProfileBookmark::where('user_id', $me->id)
            ->where('target_user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status', 'Bookmark removed.');
        }

        ProfileBookmark::create(['user_id' => $me->id, 'target_user_id' => $user->id]);

        return back()->with('status', 'Profile bookmarked.');
    }

    public function poke(Request $request, User $user): RedirectResponse
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 403);

        Poke::create(['sender_id' => $me->id, 'recipient_id' => $user->id]);

        AppNotification::notify(
            $user->id,
            'poke',
            "{$me->name} poked you 👋",
            null,
            route('directory.show', $me)
        );

        return back()->with('status', "You poked {$user->name}.");
    }

    public function bookmarks(Request $request): View
    {
        $bookmarks = User::whereIn('id', function ($q) use ($request) {
            $q->select('target_user_id')->from('profile_bookmarks')->where('user_id', $request->user()->id);
        })->with('profile')->paginate(12);

        return view('profile.bookmarks', compact('bookmarks'));
    }

    public function likes(Request $request): View
    {
        $likes = User::whereIn('id', function ($q) use ($request) {
            $q->select('target_user_id')->from('profile_likes')->where('user_id', $request->user()->id);
        })->with('profile')->paginate(12);

        return view('profile.likes', compact('likes'));
    }
}
