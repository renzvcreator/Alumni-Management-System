<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::active()
            ->orderByRaw('CASE WHEN event_date >= ? THEN 0 ELSE 1 END', [now()]) // upcoming first
            ->orderBy('event_date')                                              // soonest first
            ->paginate(10);
        $rsvpEventIds = $request->user()->events()->pluck('events.id')->all();

        return view('events.index', compact('events', 'rsvpEventIds'));
    }

    public function myRsvps(Request $request): View
    {
        $events = $request->user()->events()
            ->orderByDesc('event_date')
            ->paginate(12);

        return view('events.my-rsvps', compact('events'));
    }

    public function show(Request $request, Event $event): View
    {
        abort_if($event->isArchived(), 404);
        $hasRsvp = $request->user()->events()->where('events.id', $event->id)->exists();

        return view('events.show', compact('event', 'hasRsvp'));
    }

    public function rsvp(Request $request, Event $event): RedirectResponse
    {
        abort_if($event->isArchived(), 404);
        $request->user()->events()->syncWithoutDetaching([
            $event->id => ['rsvp_at' => now()],
        ]);

        return back()->with('status', 'RSVP confirmed for '.$event->title);
    }

    public function cancelRsvp(Request $request, Event $event): RedirectResponse
    {
        $request->user()->events()->detach($event->id);

        return back()->with('status', 'RSVP cancelled for '.$event->title);
    }
}
