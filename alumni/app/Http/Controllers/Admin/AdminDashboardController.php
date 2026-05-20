<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending' => User::where('role', 'alumni')->where('status', 'pending')->count(),
            'approved' => User::where('role', 'alumni')->where('status', 'approved')->count(),
            'blocked' => User::where('status', 'blocked')->count(),
            'events' => Event::count(),
            'announcements' => Announcement::count(),
        ];

        $recentPending = User::with('profile')
            ->where('role', 'alumni')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPending'));
    }
}
