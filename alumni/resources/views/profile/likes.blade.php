<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Liked Profiles</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="rounded-md bg-pink-50 border border-pink-200 text-pink-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            <p class="text-sm text-gray-500">Profiles you've liked.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($likes as $a)
                    @php $p = $a->profile; @endphp
                    <a href="{{ route('directory.show', $a) }}" class="block bg-white shadow sm:rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-4">
                            @if ($p && $p->profile_picture_url)
                                <img src="{{ $p->profile_picture_url }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-pink-100 text-pink-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr($p?->first_name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $p?->full_name ?? $a->name }}</div>
                                <div class="text-xs text-gray-500">
                                    @if ($p?->graduation_year) Class of {{ $p->graduation_year }} @endif
                                </div>
                            </div>
                            <svg class="w-5 h-5 ms-auto text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white shadow sm:rounded-xl p-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                        <p class="mt-4 text-gray-500">You haven't liked anyone's profile yet.</p>
                        <a href="{{ route('directory.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-700 hover:underline">
                            Find people to like
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @endforelse
            </div>

            <div>{{ $likes->links() }}</div>
        </div>
    </div>
</x-app-layout>
