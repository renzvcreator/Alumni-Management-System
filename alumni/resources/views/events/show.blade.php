<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Details</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm mb-4">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                @if ($event->image_path)
                    <img src="{{ $event->image_path }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-8">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Back to Home
                    </a>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-md px-3 py-1.5 transition">
                        All Events
                    </a>
                </div>
                <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $event->event_date->format('l, M d, Y g:i A') }} · {{ $event->location }}</p>
                <div class="mt-6 text-gray-800 whitespace-pre-line leading-relaxed">{{ $event->description }}</div>

                <div class="mt-8">
                    @if ($hasRsvp)
                        <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">Cancel RSVP</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('events.rsvp', $event) }}">
                            @csrf
                            <button class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">RSVP</button>
                        </form>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
