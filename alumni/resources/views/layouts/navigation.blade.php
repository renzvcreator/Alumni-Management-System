@php
    $user = Auth::user();
    $isAdmin = $user && $user->isAdmin();
    $isApprovedAlumni = $user && $user->isAlumni() && $user->isApproved();

    $linkBase = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition';
    $linkIdle = 'text-indigo-100 hover:text-white hover:bg-indigo-600';
    $linkActive = 'bg-indigo-900 text-white';
@endphp

<nav x-data="{ open: false }" class="bg-indigo-700 text-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ $isAdmin ? route('admin.dashboard') : ($isApprovedAlumni ? route('dashboard') : route('home')) }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto fill-current text-white" />
                        <span class="font-semibold text-white hidden sm:block">Alumni</span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:ms-8 sm:items-center sm:gap-1">
                    @guest
                        <a href="{{ route('home') }}" class="{{ $linkBase }} {{ request()->routeIs('home') ? $linkActive : $linkIdle }}">Home</a>
                        <a href="{{ route('about') }}" class="{{ $linkBase }} {{ request()->routeIs('about') ? $linkActive : $linkIdle }}">About</a>
                    @endguest

                    @auth
                        @if ($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" class="{{ $linkBase }} {{ request()->routeIs('admin.dashboard') ? $linkActive : $linkIdle }}">Home</a>
                            <a href="{{ route('admin.users.index') }}" class="{{ $linkBase }} {{ request()->routeIs('admin.users.*') ? $linkActive : $linkIdle }}">User Management</a>
                            <a href="{{ route('admin.events.index') }}" class="{{ $linkBase }} {{ request()->routeIs('admin.events.*') ? $linkActive : $linkIdle }}">Events</a>
                            <a href="{{ route('admin.announcements.index') }}" class="{{ $linkBase }} {{ request()->routeIs('admin.announcements.*') ? $linkActive : $linkIdle }}">Announcements</a>
                        @elseif ($isApprovedAlumni)
                            <a href="{{ route('dashboard') }}" class="{{ $linkBase }} {{ request()->routeIs('dashboard') ? $linkActive : $linkIdle }}">Home</a>
                            <a href="{{ route('profile.edit') }}" class="{{ $linkBase }} {{ request()->routeIs('profile.edit') ? $linkActive : $linkIdle }}">Profile</a>
                            <a href="{{ route('directory.index') }}" class="{{ $linkBase }} {{ request()->routeIs('directory.*') ? $linkActive : $linkIdle }}">Connect with People</a>
                            <a href="{{ route('announcements.index') }}" class="{{ $linkBase }} {{ request()->routeIs('announcements.*') ? $linkActive : $linkIdle }}">Announcements</a>
                            <a href="{{ route('events.index') }}" class="{{ $linkBase }} {{ request()->routeIs('events.*') ? $linkActive : $linkIdle }}">Events</a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                @guest
                    <button type="button" @click="$store.auth.open('login')" class="inline-flex items-center px-4 py-1.5 rounded-md text-sm font-medium text-white border border-white/50 hover:bg-indigo-600">Sign in</button>
                    <button type="button" @click="$store.auth.open('register')" class="inline-flex items-center px-4 py-1.5 rounded-md text-sm font-semibold text-indigo-700 bg-white hover:bg-indigo-50">Register</button>
                @endguest

                @auth
                    @if ($isApprovedAlumni)
                        {{-- Messages --}}
                        <a href="{{ route('messages.index') }}"
                           class="relative inline-flex items-center p-2 rounded-full transition {{ request()->routeIs('messages.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:text-white hover:bg-indigo-600' }}"
                           aria-label="Messages">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            @if (($navUnreadMessages ?? 0) > 0)
                                <span class="absolute top-1 right-1 inline-flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] leading-none font-semibold ring-2 ring-indigo-700">{{ $navUnreadMessages > 9 ? '9+' : $navUnreadMessages }}</span>
                            @endif
                        </a>

                        <div x-data="{ unread: {{ (int) ($navUnreadCount ?? 0) }} }" class="relative">
                            <x-dropdown align="right" width="80">
                                <x-slot name="trigger">
                                    <button
                                        class="relative inline-flex items-center p-2 rounded-full text-indigo-100 hover:text-white hover:bg-indigo-600 focus:outline-none transition"
                                        aria-label="Notifications"
                                        @click="if (unread > 0) { fetch('{{ route('notifications.readAll') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, credentials: 'same-origin' }); unread = 0; }"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                        </svg>
                                        <span x-show="unread > 0" x-cloak class="absolute top-1 right-1 inline-flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] leading-none font-semibold ring-2 ring-indigo-700">
                                            <span x-text="unread > 9 ? '9+' : unread"></span>
                                        </span>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                                        <span class="text-base font-semibold text-gray-900">Notifications</span>
                                    </div>
                                    <div class="max-h-96 min-h-[180px] overflow-y-auto divide-y divide-gray-100">
                                        @forelse ($navRecentNotifications as $n)
                                            <a href="{{ $n->link ?? route('notifications.index') }}" class="flex items-start gap-3 px-5 py-4 hover:bg-indigo-50 transition {{ $n->read_at ? '' : 'bg-indigo-50/60' }}">
                                                @php
                                                    $navColorMap = [
                                                        'message' => 'bg-indigo-100 text-indigo-700',
                                                        'like' => 'bg-pink-100 text-pink-700',
                                                        'poke' => 'bg-amber-100 text-amber-700',
                                                        'event' => 'bg-emerald-100 text-emerald-700',
                                                        'announcement' => 'bg-indigo-100 text-indigo-700',
                                                    ];
                                                    $navIconMap = [
                                                        'message' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>',
                                                        'like' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg>',
                                                        'poke' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>',
                                                        'event' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/></svg>',
                                                        'announcement' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>',
                                                    ];
                                                    $navIcon = $navIconMap[$n->type] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31"/></svg>';
                                                    $navColor = $navColorMap[$n->type] ?? 'bg-gray-100 text-gray-600';
                                                @endphp
                                                <div class="h-9 w-9 shrink-0 rounded-full {{ $navColor }} flex items-center justify-center">
                                                    {!! $navIcon !!}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm leading-snug {{ $n->read_at ? 'text-gray-600' : 'text-gray-900 font-semibold' }}">{{ $n->title }}</div>
                                                    @if ($n->body)
                                                        <div class="text-xs text-gray-500 truncate mt-0.5">{{ $n->body }}</div>
                                                    @endif
                                                    <div class="text-[11px] text-gray-400 mt-1.5">{{ $n->created_at->diffForHumans() }}</div>
                                                </div>
                                                @unless ($n->read_at)
                                                    <span class="h-2 w-2 mt-2 rounded-full bg-indigo-500 shrink-0"></span>
                                                @endunless
                                            </a>
                                        @empty
                                            <div class="px-5 py-8 text-center">
                                                <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                                </div>
                                                <p class="mt-3 text-sm font-medium text-gray-700">You're all caught up</p>
                                                <p class="mt-1 text-xs text-gray-500">New notifications will appear here.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                                        <a href="{{ route('notifications.index') }}" class="flex items-center justify-center gap-1.5 w-full text-sm font-semibold text-indigo-700 bg-white hover:bg-indigo-50 border border-indigo-200 rounded-md px-3 py-2 transition">
                                            View all notifications
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-white hover:bg-indigo-600 focus:outline-none transition">
                                <div>{{ $user->name }}</div>
                                <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (!$isAdmin)
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-100 hover:text-white hover:bg-indigo-600 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-700">
        <div class="pt-2 pb-3 space-y-1 px-2">
            @php
                $mobileIdle = 'block px-3 py-2 rounded-md text-base font-medium text-indigo-100 hover:text-white hover:bg-indigo-600';
                $mobileActive = 'block px-3 py-2 rounded-md text-base font-medium bg-indigo-900 text-white';
            @endphp

            @guest
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $mobileActive : $mobileIdle }}">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? $mobileActive : $mobileIdle }}">About</a>
                <button type="button" @click="$store.auth.open('login'); open=false" class="{{ $mobileIdle }} w-full text-left">Login</button>
                <button type="button" @click="$store.auth.open('register'); open=false" class="{{ $mobileIdle }} w-full text-left">Sign Up</button>
            @endguest

            @auth
                @if ($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? $mobileActive : $mobileIdle }}">Home</a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? $mobileActive : $mobileIdle }}">User Management</a>
                    <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? $mobileActive : $mobileIdle }}">Events</a>
                    <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? $mobileActive : $mobileIdle }}">Announcements</a>
                @elseif ($isApprovedAlumni)
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $mobileActive : $mobileIdle }}">Home</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? $mobileActive : $mobileIdle }}">Profile</a>
                    <a href="{{ route('directory.index') }}" class="{{ request()->routeIs('directory.*') ? $mobileActive : $mobileIdle }}">Connect with People</a>
                    <a href="{{ route('announcements.index') }}" class="{{ request()->routeIs('announcements.*') ? $mobileActive : $mobileIdle }}">Announcements</a>
                    <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? $mobileActive : $mobileIdle }}">Events</a>
                    <a href="{{ route('messages.index') }}" class="{{ request()->routeIs('messages.*') ? $mobileActive : $mobileIdle }}">Messages @if (($navUnreadMessages ?? 0) > 0)<span class="ml-1 inline-flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px]">{{ $navUnreadMessages }}</span>@endif</a>
                    <a href="{{ route('notifications.index') }}" class="{{ $mobileIdle }}">Notifications @if (($navUnreadCount ?? 0) > 0)<span class="ml-1 inline-flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px]">{{ $navUnreadCount }}</span>@endif</a>
                @endif
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-indigo-800">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ $user->name }}</div>
                    <div class="font-medium text-sm text-indigo-200">{{ $user->email }}</div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="{{ $mobileIdle }}">Log Out</a>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
