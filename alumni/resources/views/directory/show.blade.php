<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alumni Profile</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif

            <a href="{{ route('directory.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to People
            </a>

            @php $p = $user->profile; @endphp

            <div class="bg-white shadow rounded-2xl overflow-hidden ring-1 ring-gray-100">
                {{-- Cover banner --}}
                <div class="relative h-32 bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600">
                    <div class="pointer-events-none absolute -top-8 -right-8 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="pointer-events-none absolute -bottom-10 -left-6 h-28 w-28 rounded-full bg-white/10"></div>
                </div>

                <div class="relative px-6 sm:px-8 pb-8">
                    {{-- Avatar overlapping the banner --}}
                    <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-14">
                        @if ($p->profile_picture_url)
                            <img src="{{ $p->profile_picture_url }}" class="h-28 w-28 rounded-2xl object-cover ring-4 ring-white shadow-md shrink-0">
                        @else
                            <div class="h-28 w-28 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-4xl font-bold ring-4 ring-white shadow-md shrink-0">
                                {{ strtoupper(substr($p->first_name, 0, 1) . substr($p->last_name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-1 min-w-0 sm:pb-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $p->full_name }}</h1>
                                @if ($isSelf)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">You</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-0.5">
                                @if ($p->graduation_year) Class of {{ $p->graduation_year }} @endif
                                @if ($p->industry) · {{ $p->industry }} @endif
                            </p>
                        </div>

                        <div class="sm:pb-2">
                            <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 bg-pink-50 px-3 py-1.5 rounded-full">
                                <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg>
                                <span class="font-semibold text-gray-900">{{ $likesCount }}</span> {{ Str::plural('like', $likesCount) }}
                            </span>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    @unless ($isSelf)
                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('messages.show', $user) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/20 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                Message
                            </a>
                            <form method="POST" action="{{ route('profiles.like', $user) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium transition {{ $liked ? 'bg-pink-100 text-pink-700 border border-pink-300 hover:bg-pink-200' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                                    @if ($liked)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg>
                                        Liked
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                                        Like
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('profiles.bookmark', $user) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium transition {{ $bookmarked ? 'bg-amber-100 text-amber-700 border border-amber-300 hover:bg-amber-200' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                                    @if ($bookmarked)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z"/></svg>
                                        Saved
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>
                                        Save
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('profiles.poke', $user) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                    Poke
                                </button>
                            </form>
                        </div>
                    @endunless

                    {{-- Details --}}
                    <dl class="mt-8 pt-6 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <div class="min-w-0">
                                <dt class="text-xs uppercase text-gray-500">Email</dt>
                                <dd class="mt-0.5 text-sm text-gray-900 break-all">{{ $user->email }}</dd>
                            </div>
                        </div>
                        @if ($p->contact_number)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                <div class="min-w-0">
                                    <dt class="text-xs uppercase text-gray-500">Contact</dt>
                                    <dd class="mt-0.5 text-sm text-gray-900">{{ $p->contact_number }}</dd>
                                </div>
                            </div>
                        @endif
                        @if ($p->current_job)
                            <div class="flex items-start gap-3 sm:col-span-2">
                                <svg class="w-5 h-5 mt-0.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                <div class="min-w-0">
                                    <dt class="text-xs uppercase text-gray-500">Current Job</dt>
                                    <dd class="mt-0.5 text-sm text-gray-900">{{ $p->current_job }}</dd>
                                </div>
                            </div>
                        @endif
                    </dl>

                    @if ($p->bio)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">About</h3>
                            <p class="mt-3 text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $p->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
