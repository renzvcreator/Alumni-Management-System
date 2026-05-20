<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Events</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div class="inline-flex rounded-lg border border-gray-200 bg-white overflow-hidden shadow-sm">
                    <a href="{{ route('admin.events.index', ['tab' => 'active']) }}"
                       class="px-4 py-2 text-sm font-medium {{ $tab === 'active' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                        Active ({{ $counts['active'] }})
                    </a>
                    <a href="{{ route('admin.events.index', ['tab' => 'archived']) }}"
                       class="px-4 py-2 text-sm font-medium border-l border-gray-200 {{ $tab === 'archived' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                        Archived ({{ $counts['archived'] }})
                    </a>
                </div>
                <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">+ New Event</a>
            </div>

            <div class="bg-white shadow sm:rounded-xl overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Event</th>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Location</th>
                            <th class="px-4 py-3 text-left">Attendees</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $e)
                            <tr class="border-t border-gray-100 align-top">
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-start">
                                        @if ($e->image_path)
                                            <img src="{{ $e->image_path }}" class="w-16 h-12 object-cover rounded border border-gray-200 shrink-0">
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $e->title }}</div>
                                            @if ($e->isArchived())
                                                <span class="inline-block text-[10px] uppercase tracking-wide text-gray-500 bg-gray-100 border border-gray-200 rounded px-1.5 py-0.5 mt-1">Archived {{ $e->archived_at->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $e->event_date->format('M d, Y g:i A') }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $e->location }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.events.attendees', $e) }}" class="text-indigo-700 hover:underline font-medium">{{ $e->attendees_count }}</a>
                                </td>
                                <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                    @if ($e->isArchived())
                                        <form method="POST" action="{{ route('admin.events.unarchive', $e) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700">Unarchive</button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.events.edit', $e) }}" class="inline-flex items-center px-3 py-1 rounded text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.events.archive', $e) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700">Archive</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.events.destroy', $e) }}" class="inline" onsubmit="return confirm('Delete event permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-red-600 hover:bg-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                @if ($tab === 'archived')
                                    No archived events. Archive an event to preserve its attendee record.
                                @else
                                    No active events. Create your first one.
                                @endif
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $events->links() }}</div>
        </div>
    </div>
</x-app-layout>
