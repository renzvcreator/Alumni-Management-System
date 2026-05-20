<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $year = $request->query('graduation_year');
        $industry = trim((string) $request->query('industry', ''));

        $query = User::query()
            ->where('role', 'alumni')
            ->where('status', 'approved')
            ->where('id', '!=', $request->user()->id)
            ->with('profile')
            ->whereHas('profile');

        if ($search !== '') {
            $query->whereHas('profile', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($year) {
            $yearInt = is_numeric($year) ? (int) $year : (int) date('Y', strtotime($year));
            $query->whereHas('profile', fn ($q) => $q->where('graduation_year', $yearInt));
        }

        if ($industry !== '') {
            $query->whereHas('profile', fn ($q) => $q->where('industry', 'like', "%{$industry}%"));
        }

        $alumni = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();

        $me = $request->user();
        $likedIds = \App\Models\ProfileLike::where('user_id', $me->id)->pluck('target_user_id')->all();
        $bookmarkedIds = \App\Models\ProfileBookmark::where('user_id', $me->id)->pluck('target_user_id')->all();

        $years = \App\Models\Profile::whereNotNull('graduation_year')
            ->distinct()
            ->orderByDesc('graduation_year')
            ->pluck('graduation_year');

        $industries = \App\Models\Profile::whereNotNull('industry')
            ->where('industry', '!=', '')
            ->distinct()
            ->orderBy('industry')
            ->pluck('industry');

        return view('directory.index', compact('alumni', 'search', 'year', 'industry', 'years', 'industries', 'likedIds', 'bookmarkedIds', 'me'));
    }

    public function show(Request $request, User $user): View
    {
        abort_unless($user->role === 'alumni' && $user->status === 'approved', 404);
        $user->load('profile');

        $me = $request->user();
        $isSelf = $me->id === $user->id;
        $liked = ! $isSelf && \App\Models\ProfileLike::where('user_id', $me->id)->where('target_user_id', $user->id)->exists();
        $bookmarked = ! $isSelf && \App\Models\ProfileBookmark::where('user_id', $me->id)->where('target_user_id', $user->id)->exists();
        $likesCount = \App\Models\ProfileLike::where('target_user_id', $user->id)->count();

        return view('directory.show', compact('user', 'isSelf', 'liked', 'bookmarked', 'likesCount'));
    }
}
