<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Announcement</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="bg-white shadow sm:rounded-xl p-6 space-y-4">
                @csrf
                <div>
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" :value="old('title')" class="mt-1 block w-full" required placeholder="e.g. Annual Homecoming 2026" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>
                <div>
                    <x-input-label for="content" value="Content" />
                    <textarea id="content" name="content" rows="8" placeholder="Write the full announcement here. Include any important dates, contact information, or links." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('content') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                </div>
                <div>
                    <x-input-label for="image" value="Image (optional)" />
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-700">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max 4MB.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
                <div class="flex gap-3">
                    <x-primary-button>Post</x-primary-button>
                    <a href="{{ route('admin.announcements.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
