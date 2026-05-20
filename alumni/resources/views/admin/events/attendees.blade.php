<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Attendees</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.events.index', ['tab' => $event->isArchived() ? 'archived' : 'active']) }}"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Events
            </a>

            <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                @if ($event->image_path)
                    <img src="{{ $event->image_path }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                            <p class="text-sm text-gray-500 mt-1">{{ $event->event_date->format('l, M d, Y g:i A') }} · {{ $event->location }}</p>
                        </div>
                        @if ($event->isArchived())
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                Archived on {{ $event->archived_at->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                    <p class="mt-4 text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Attendance Record</h3>
                    <span class="text-sm text-gray-500">{{ $event->attendees->count() }} {{ Str::plural('alumnus', $event->attendees->count()) }}</span>
                </div>

                @if ($event->attendees->isEmpty())
                    <div class="p-10 text-center text-gray-500">No alumni RSVP'd to this event.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Graduation</th>
                                <th class="px-6 py-3 text-left">RSVP'd At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->attendees as $a)
                                <tr class="border-t border-gray-100">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            @if ($a->profile?->profile_picture_url)
                                                <img src="{{ $a->profile->profile_picture_url }}" class="h-8 w-8 rounded-full object-cover">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold">
                                                    {{ strtoupper(substr($a->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="font-medium text-gray-900">{{ $a->profile?->full_name ?? $a->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">{{ $a->email }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $a->profile?->graduation_year ?? '—' }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ \Carbon\Carbon::parse($a->pivot->rsvp_at)->format('M d, Y g:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
