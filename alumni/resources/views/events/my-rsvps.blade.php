<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My RSVPs</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            <p class="text-sm text-gray-500">Events you've RSVP'd to.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="block bg-white shadow sm:rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-4">
                            @if ($event->image_path)
                                <img src="{{ $event->image_path }}" class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="h-12 w-12 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $event->title }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $event->event_date->format('M d, Y') }}</div>
                            </div>
                            <svg class="w-5 h-5 ms-auto text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white shadow sm:rounded-xl p-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/></svg>
                        <p class="mt-4 text-gray-500">You haven't RSVP'd to any events yet.</p>
                        <a href="{{ route('events.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-700 hover:underline">
                            Browse upcoming events
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @endforelse
            </div>

            <div>{{ $events->links() }}</div>
        </div>
    </div>
</x-app-layout>
