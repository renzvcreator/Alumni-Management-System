<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('admin')->latest()->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement): View
    {
        $announcement->load('admin');

        return view('announcements.show', compact('announcement'));
    }
}
