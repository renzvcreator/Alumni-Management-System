<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Announcement</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-xl overflow-hidden">
                @if ($announcement->image_path)
                    <img src="{{ $announcement->image_path }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-8">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Back to Home
                        </a>
                        <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-md px-3 py-1.5 transition">
                            All Announcements
                        </a>
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $announcement->title }}</h1>
                    <p class="text-xs text-gray-500 mt-1">{{ $announcement->created_at->format('M d, Y g:i A') }} · {{ $announcement->admin->name }}</p>
                    <div class="mt-6 text-gray-800 whitespace-pre-line leading-relaxed">{{ $announcement->content }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
