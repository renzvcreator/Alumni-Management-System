<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Events</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            @if ($events->isEmpty())
                <div class="bg-white shadow sm:rounded-xl p-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/></svg>
                    <p class="mt-4 text-gray-500">No events scheduled yet.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($events as $event)
                        @php
                            $isRsvp = in_array($event->id, $rsvpEventIds);
                            $isPast = $event->event_date->isPast();
                        @endphp
                        <div class="group flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
                            {{-- Image / placeholder with date chip --}}
                            <a href="{{ route('events.show', $event) }}" class="relative block h-44 overflow-hidden">
                                @if ($event->image_path)
                                    <img src="{{ $event->image_path }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="h-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/></svg>
                                    </div>
                                @endif
                                {{-- date chip --}}
                                <div class="absolute top-3 left-3 bg-white rounded-lg shadow px-3 py-1.5 text-center">
                                    <div class="text-[10px] font-semibold uppercase text-indigo-600 leading-none">{{ $event->event_date->format('M') }}</div>
                                    <div class="text-lg font-bold text-gray-900 leading-tight">{{ $event->event_date->format('d') }}</div>
                                </div>
                                @if ($isRsvp)
                                    <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-emerald-700 bg-white/95 shadow">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        Going
                                    </span>
                                @endif
                            </a>

                            {{-- Body --}}
                            <div class="flex flex-col flex-1 p-5">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 line-clamp-2">
                                    <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                                </h3>
                                <div class="mt-2 space-y-1.5 text-sm text-gray-500">
                                    <div class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $event->event_date->format('M d, Y · g:i A') }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"/></svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 text-sm text-gray-600 line-clamp-2 leading-relaxed flex-1">{{ $event->description }}</p>

                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    @if ($isRsvp)
                                        <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Cancel RSVP
                                            </button>
                                        </form>
                                    @elseif ($isPast)
                                        <span class="block text-center text-sm text-gray-400 font-medium py-2">Event has ended</span>
                                    @else
                                        <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                            @csrf
                                            <button class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/20 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                                RSVP
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div>{{ $events->links() }}</div>
        </div>
    </div>
</x-app-layout>
