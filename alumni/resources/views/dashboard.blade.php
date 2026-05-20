<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    @php
        $iconClass = 'w-5 h-5';
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Welcome hero --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-indigo-500 text-white shadow-lg">
                <div class="absolute -top-10 -right-10 h-48 w-48 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-12 -left-8 h-40 w-40 rounded-full bg-white/10"></div>
                <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="shrink-0">
                        @if ($me->profile?->profile_picture_url)
                            <img src="{{ $me->profile->profile_picture_url }}" class="h-20 w-20 rounded-full object-cover ring-4 ring-white/30">
                        @else
                            <div class="h-20 w-20 rounded-full bg-white/20 text-white flex items-center justify-center text-2xl font-bold ring-4 ring-white/30">
                                {{ strtoupper(substr($me->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-indigo-100 text-sm">{{ now()->format('l, F j, Y') }}</p>
                        <h1 class="text-2xl sm:text-3xl font-bold mt-1">Welcome back, {{ $me->profile?->first_name ?? $me->name }}!</h1>
                        <p class="text-indigo-100 mt-2">
                            @if ($unreadMessages > 0)
                                You have <strong class="text-white">{{ $unreadMessages }}</strong> unread {{ Str::plural('message', $unreadMessages) }}.
                            @else
                                Reconnect with classmates and stay updated with the latest news.
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/30">Edit Profile</a>
                    </div>
                </div>
            </div>

            {{-- Stats row --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('directory.index') }}" class="bg-white shadow sm:rounded-xl p-5 flex items-center gap-3 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['alumni'] }}</div>
                        <div class="text-xs text-gray-500">Total Alumni</div>
                    </div>
                </a>

                <a href="{{ route('events.my-rsvps') }}" class="bg-white shadow sm:rounded-xl p-5 flex items-center gap-3 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['rsvps'] }}</div>
                        <div class="text-xs text-gray-500">My RSVPs</div>
                    </div>
                </a>

                <a href="{{ route('profiles.likes') }}" class="bg-white shadow sm:rounded-xl p-5 flex items-center gap-3 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-pink-100 text-pink-700 flex items-center justify-center">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['likes'] }}</div>
                        <div class="text-xs text-gray-500">Liked Profiles</div>
                    </div>
                </a>

                <a href="{{ route('profiles.bookmarks') }}" class="bg-white shadow sm:rounded-xl p-5 flex items-center gap-3 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['bookmarks'] }}</div>
                        <div class="text-xs text-gray-500">Bookmarks</div>
                    </div>
                </a>
            </div>

            {{-- Quick actions --}}
            <div class="bg-white shadow sm:rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="{{ route('directory.index') }}" class="group flex flex-col items-center justify-center text-center p-4 rounded-lg border border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center mb-2">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700">Connect with People</div>
                        <div class="text-xs text-gray-500 mt-0.5">Find classmates</div>
                    </a>

                    <a href="{{ route('messages.index') }}" class="group flex flex-col items-center justify-center text-center p-4 rounded-lg border border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition relative">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center mb-2">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700">Messages</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $unreadMessages > 0 ? $unreadMessages.' unread' : 'Open inbox' }}</div>
                        @if ($unreadMessages > 0)
                            <span class="absolute top-2 right-2 inline-flex items-center justify-center min-w-[18px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] font-semibold">{{ $unreadMessages }}</span>
                        @endif
                    </a>

                    <a href="{{ route('events.index') }}" class="group flex flex-col items-center justify-center text-center p-4 rounded-lg border border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center mb-2">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700">Events</div>
                        <div class="text-xs text-gray-500 mt-0.5">Browse + RSVP</div>
                    </a>

                    <a href="{{ route('announcements.index') }}" class="group flex flex-col items-center justify-center text-center p-4 rounded-lg border border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center mb-2">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700">Announcements</div>
                        <div class="text-xs text-gray-500 mt-0.5">Latest news</div>
                    </a>
                </div>
            </div>

            {{-- Two-column: announcements + events --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                            </svg>
                            <h3 class="text-base font-semibold text-gray-900">Latest Announcements</h3>
                        </div>
                        <a href="{{ route('announcements.index') }}" class="text-xs font-semibold text-indigo-700 hover:underline">View all</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($announcements as $a)
                            <a href="{{ route('announcements.show', $a) }}" class="flex gap-3 px-6 py-4 hover:bg-indigo-50/40 transition">
                                @if ($a->image_path)
                                    <img src="{{ $a->image_path }}" class="w-20 h-20 object-cover rounded-md shrink-0">
                                @else
                                    <div class="w-20 h-20 rounded-md bg-indigo-50 text-indigo-400 flex items-center justify-center shrink-0">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium text-gray-900 truncate">{{ $a->title }}</div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $a->created_at->diffForHumans() }} · {{ $a->admin->name }}</p>
                                    <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ $a->content }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-gray-500">No announcements yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                            <h3 class="text-base font-semibold text-gray-900">Upcoming Events</h3>
                        </div>
                        <a href="{{ route('events.index') }}" class="text-xs font-semibold text-indigo-700 hover:underline">View all</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($upcomingEvents as $event)
                            <div class="relative hover:bg-indigo-50/40 transition">
                                <a href="{{ route('events.show', $event) }}" class="flex gap-3 px-6 py-4">
                                    @if ($event->image_path)
                                        <img src="{{ $event->image_path }}" class="w-20 h-20 object-cover rounded-md shrink-0">
                                    @else
                                        <div class="w-20 h-20 rounded-md bg-indigo-50 text-indigo-400 flex items-center justify-center shrink-0">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/></svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0 pr-24">
                                        <div class="font-medium text-gray-900 truncate">{{ $event->title }}</div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $event->event_date->format('M d, Y · g:i A') }}</p>
                                        <p class="text-xs text-gray-500 truncate flex items-center gap-1">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"/></svg>
                                            {{ $event->location }}
                                        </p>
                                    </div>
                                </a>
                                <div class="absolute top-1/2 -translate-y-1/2 right-6">
                                    @if (in_array($event->id, $rsvpEventIds))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            RSVP'd
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                            @csrf
                                            <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700">RSVP</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-gray-500">No upcoming events.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Featured Alumni --}}
            @if ($featuredAlumni->isNotEmpty())
                <div class="bg-white shadow sm:rounded-xl p-6">
                    <div class="mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Discover Alumni</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach ($featuredAlumni as $a)
                            @php $p = $a->profile; @endphp
                            <a href="{{ route('directory.show', $a) }}" class="block text-center p-4 rounded-lg border border-gray-100 hover:border-indigo-300 hover:shadow-sm transition">
                                @if ($p->profile_picture_url)
                                    <img src="{{ $p->profile_picture_url }}" class="h-16 w-16 rounded-full object-cover mx-auto">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold mx-auto">
                                        {{ strtoupper(substr($p->first_name, 0, 1) . substr($p->last_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="font-medium text-gray-900 text-sm mt-3 truncate">{{ $p->full_name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5 truncate">
                                    @if ($p->graduation_year) Class of {{ $p->graduation_year }} @else {{ $p->industry ?? 'Alumni' }} @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
