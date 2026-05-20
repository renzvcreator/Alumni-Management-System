<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->isBlocked()) {
                return redirect()->route('login');
            }

            if ($user->isPending()) {
                return redirect()->route('pending');
            }

            return redirect()->route('dashboard');
        }

        $stats = [
            'alumni'        => User::where('role', 'alumni')->where('status', 'approved')->count(),
            'events'        => Event::count(),
            'announcements' => Announcement::count(),
        ];

        return view('pages.home', compact('stats'));
    }

    public function about(): View
    {
        $stats = [
            'alumni'        => User::where('role', 'alumni')->where('status', 'approved')->count(),
            'events'        => Event::count(),
            'announcements' => Announcement::count(),
            'years'         => 1, // placeholder for "years connecting alumni"
        ];

        return view('pages.about', compact('stats'));
    }

    public function pending(): View
    {
        return view('pages.pending');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
