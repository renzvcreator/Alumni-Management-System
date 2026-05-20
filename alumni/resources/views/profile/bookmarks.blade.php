<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bookmarked Profiles</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="rounded-md bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            <p class="text-sm text-gray-500">Profiles you've bookmarked.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($bookmarks as $a)
                    @php $p = $a->profile; @endphp
                    <a href="{{ route('directory.show', $a) }}" class="block bg-white shadow sm:rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-4">
                            @if ($p && $p->profile_picture_url)
                                <img src="{{ $p->profile_picture_url }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr($p?->first_name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $p?->full_name ?? $a->name }}</div>
                                <div class="text-xs text-gray-500">
                                    @if ($p?->graduation_year) Class of {{ $p->graduation_year }} @endif
                                </div>
                            </div>
                            <svg class="w-5 h-5 ms-auto text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z"/></svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white shadow sm:rounded-xl p-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>
                        <p class="mt-4 text-gray-500">You haven't bookmarked anyone yet.</p>
                        <a href="{{ route('directory.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-700 hover:underline">
                            Find people to bookmark
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @endforelse
            </div>

            <div>{{ $bookmarks->links() }}</div>
        </div>
    </div>
</x-app-layout>
