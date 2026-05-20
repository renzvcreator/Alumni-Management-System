<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('admin')->latest()->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = Storage::url($request->file('image')->store('announcements', 'public'));
        }
        unset($data['image']);

        $announcement = Announcement::create([
            'admin_id' => $request->user()->id,
            ...$data,
        ]);

        $recipients = User::where('role', 'alumni')->where('status', 'approved')->pluck('id');
        $now = now();
        $rows = $recipients->map(fn ($id) => [
            'user_id' => $id,
            'type' => 'announcement',
            'title' => 'New announcement: '.$announcement->title,
            'body' => \Illuminate\Support\Str::limit($announcement->content, 100),
            'link' => route('announcements.show', $announcement),
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();
        if ($rows) AppNotification::insert($rows);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement posted.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->boolean('remove_image') && $announcement->image_path) {
            $this->deleteImage($announcement->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                $this->deleteImage($announcement->image_path);
            }
            $data['image_path'] = Storage::url($request->file('image')->store('announcements', 'public'));
        }

        unset($data['image'], $data['remove_image']);

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->image_path) {
            $this->deleteImage($announcement->image_path);
        }
        $announcement->delete();

        return back()->with('status', 'Announcement deleted.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function deleteImage(string $url): void
    {
        $relative = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        $relative = preg_replace('#^storage/#', '', $relative);
        Storage::disk('public')->delete($relative);
    }
}
