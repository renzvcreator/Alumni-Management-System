<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat with {{ $partner->profile?->full_name ?? $partner->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('messages.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Messages
            </a>

            <div class="bg-white shadow rounded-2xl ring-1 ring-gray-100 overflow-hidden flex flex-col" style="height: 72vh;">
                {{-- Header --}}
                <div class="px-5 py-3 border-b border-gray-100 bg-white flex items-center gap-3">
                    <a href="{{ route('messages.index') }}" class="sm:hidden p-1.5 -ml-1 rounded-full text-gray-500 hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold overflow-hidden shrink-0 ring-2 ring-white shadow-sm">
                        @if ($partner->profile?->profile_picture_url)
                            <img src="{{ $partner->profile->profile_picture_url }}" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 truncate">{{ $partner->profile?->full_name ?? $partner->name }}</div>
                        @if ($partner->profile?->graduation_year)
                            <div class="text-xs text-gray-500">Class of {{ $partner->profile->graduation_year }}</div>
                        @endif
                    </div>
                    <a href="{{ route('directory.show', $partner) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg px-3 py-1.5 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Profile
                    </a>
                </div>

                {{-- Messages --}}
                <div class="p-6 space-y-1 flex-1 overflow-y-auto bg-gradient-to-b from-gray-50 to-white" id="chat-scroll">
                    @php $lastDate = null; @endphp
                    @forelse ($messages as $m)
                        @php
                            $mine = $m->sender_id === Auth::id();
                            $thisDate = $m->created_at->format('Y-m-d');
                            $showDate = $thisDate !== $lastDate;
                            $lastDate = $thisDate;
                        @endphp
                        @if ($showDate)
                            <div class="flex items-center justify-center my-4">
                                <span class="text-xs font-medium text-gray-500 bg-white ring-1 ring-gray-200 px-3 py-1 rounded-full shadow-sm">{{ $m->created_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                        <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }} pt-1">
                            <div class="group max-w-[75%]">
                                <div class="px-4 py-2.5 shadow-sm {{ $mine
                                    ? 'bg-indigo-600 text-white rounded-2xl rounded-br-md'
                                    : 'bg-white text-gray-900 ring-1 ring-gray-100 rounded-2xl rounded-bl-md' }}">
                                    <div class="text-sm whitespace-pre-line break-words">{{ $m->body }}</div>
                                </div>
                                <div class="mt-1 px-1 text-[10px] text-gray-400 {{ $mine ? 'text-right' : 'text-left' }}">
                                    {{ $m->created_at->format('g:i A') }}
                                    @if ($mine && $m->read_at)
                                        · <span class="text-indigo-400">Seen</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center">
                            <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-400 flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            </div>
                            <p class="mt-3 text-sm font-medium text-gray-700">No messages yet</p>
                            <p class="mt-1 text-sm text-gray-500">Say hi to start the conversation.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Composer --}}
                <form method="POST" action="{{ route('messages.store', $partner) }}" class="border-t border-gray-100 bg-white p-3 flex items-end gap-2">
                    @csrf
                    <input name="body" class="flex-1 border border-gray-300 rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" placeholder="Write a message..." required maxlength="2000" autofocus autocomplete="off" />
                    <button class="inline-flex items-center justify-center h-10 w-10 rounded-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/30 transition shrink-0" aria-label="Send">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L5.999 12zm0 0h7.5"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const el = document.getElementById('chat-scroll');
        if (el) el.scrollTop = el.scrollHeight;
    </script>
</x-app-layout>
