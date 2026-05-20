<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messages</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            <div class="bg-white shadow rounded-2xl ring-1 ring-gray-100 overflow-hidden">
                {{-- Header --}}
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-700 to-violet-600 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="h-10 w-10 rounded-xl bg-white/15 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                        </span>
                        <div>
                            <h3 class="text-base font-semibold">Inbox</h3>
                            <p class="text-xs text-indigo-100">{{ $threads->count() }} {{ Str::plural('conversation', $threads->count()) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('directory.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-700 bg-white hover:bg-indigo-50 rounded-lg px-3 py-1.5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        New
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($threads as $t)
                        @php
                            $partner = $partners[$t->partner_id] ?? null;
                            $last = $lastMessages[$t->last_id] ?? null;
                            $unread = $unreadCounts[$t->partner_id] ?? 0;
                            $mineLast = $last && $last->sender_id === Auth::id();
                        @endphp
                        @if ($partner)
                            <a href="{{ route('messages.show', $partner) }}"
                               class="relative flex items-center gap-4 px-6 py-4 hover:bg-indigo-50/50 transition {{ $unread > 0 ? 'bg-indigo-50/40' : '' }}">
                                {{-- unread accent bar --}}
                                @if ($unread > 0)
                                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-600 rounded-r"></span>
                                @endif

                                <div class="h-12 w-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold shrink-0 overflow-hidden ring-2 ring-white shadow-sm">
                                    @if ($partner->profile?->profile_picture_url)
                                        <img src="{{ $partner->profile->profile_picture_url }}" class="h-full w-full object-cover">
                                    @else
                                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="font-semibold text-gray-900 truncate">{{ $partner->profile?->full_name ?? $partner->name }}</div>
                                        <div class="text-xs shrink-0 {{ $unread > 0 ? 'text-indigo-600 font-medium' : 'text-gray-400' }}">{{ $last?->created_at?->diffForHumans(['short' => true]) }}</div>
                                    </div>
                                    <div class="text-sm truncate mt-0.5 {{ $unread > 0 ? 'text-gray-900 font-medium' : 'text-gray-500' }}">
                                        @if ($mineLast)
                                            <span class="text-gray-400">You: </span>
                                        @endif
                                        {{ $last?->body }}
                                    </div>
                                </div>
                                @if ($unread > 0)
                                    <span class="inline-flex items-center justify-center min-w-[22px] h-5 px-1.5 rounded-full bg-indigo-600 text-white text-xs font-semibold shrink-0">{{ $unread }}</span>
                                @else
                                    <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                @endif
                            </a>
                        @endif
                    @empty
                        <div class="p-12 text-center">
                            <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 text-indigo-400 flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            </div>
                            <p class="mt-4 font-medium text-gray-700">No conversations yet</p>
                            <p class="mt-1 text-sm text-gray-500">Start chatting with a fellow alumnus.</p>
                            <a href="{{ route('directory.index') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg px-4 py-2 transition">
                                Find someone to message
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
