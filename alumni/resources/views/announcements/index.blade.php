<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Announcements</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Home
            </a>

            @if ($announcements->isEmpty())
                <div class="bg-white shadow sm:rounded-xl p-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>
                    <p class="mt-4 text-gray-500">No announcements yet. Check back later.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($announcements as $a)
                        <a href="{{ route('announcements.show', $a) }}"
                           class="group flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
                            {{-- Image / placeholder --}}
                            @if ($a->image_path)
                                <div class="relative h-44 overflow-hidden">
                                    <img src="{{ $a->image_path }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            @else
                                <div class="h-44 bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>
                                </div>
                            @endif

                            {{-- Body --}}
                            <div class="flex flex-col flex-1 p-5">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/></svg>
                                    <span>{{ $a->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 line-clamp-2">{{ $a->title }}</h3>
                                <p class="mt-2 text-sm text-gray-600 line-clamp-3 leading-relaxed flex-1">{{ $a->content }}</p>

                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                                        <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-[10px] font-semibold">{{ strtoupper(substr($a->admin->name, 0, 1)) }}</span>
                                        {{ $a->admin->name }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-700">
                                        Read
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <div>{{ $announcements->links() }}</div>
        </div>
    </div>
</x-app-layout>
