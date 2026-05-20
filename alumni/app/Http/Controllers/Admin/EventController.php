<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'active');
        $query = Event::withCount('attendees')->orderBy('event_date', 'desc');

        if ($tab === 'archived') {
            $query->archived();
        } else {
            $query->active();
        }

        $events = $query->paginate(10)->withQueryString();

        $counts = [
            'active' => Event::active()->count(),
            'archived' => Event::archived()->count(),
        ];

        return view('admin.events.index', compact('events', 'tab', 'counts'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = Storage::url($request->file('image')->store('events', 'public'));
        }
        unset($data['image']);

        $event = Event::create($data);

        $recipients = User::where('role', 'alumni')->where('status', 'approved')->pluck('id');
        $now = now();
        $rows = $recipients->map(fn ($id) => [
            'user_id' => $id,
            'type' => 'event',
            'title' => 'New event: '.$event->title,
            'body' => $event->event_date->format('M d, Y g:i A').' · '.$event->location,
            'link' => route('events.show', $event),
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();
        if ($rows) AppNotification::insert($rows);

        return redirect()->route('admin.events.index')->with('status', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->boolean('remove_image') && $event->image_path) {
            $this->deleteImage($event->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                $this->deleteImage($event->image_path);
            }
            $data['image_path'] = Storage::url($request->file('image')->store('events', 'public'));
        }

        unset($data['image'], $data['remove_image']);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->image_path) {
            $this->deleteImage($event->image_path);
        }
        $event->delete();

        return back()->with('status', 'Event deleted.');
    }

    public function archive(Event $event): RedirectResponse
    {
        $event->update(['archived_at' => now()]);

        return back()->with('status', "Archived: {$event->title}");
    }

    public function unarchive(Event $event): RedirectResponse
    {
        $event->update(['archived_at' => null]);

        return back()->with('status', "Unarchived: {$event->title}");
    }

    public function attendees(Event $event): View
    {
        $event->load(['attendees' => function ($q) {
            $q->with('profile')->orderBy('pivot_rsvp_at', 'desc');
        }]);

        return view('admin.events.attendees', compact('event'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:200'],
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
