<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Event</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="bg-white shadow sm:rounded-xl p-6 space-y-4">
                @csrf
                <div>
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" :value="old('title')" class="mt-1 block w-full" required placeholder="e.g. Class of 2020 Reunion Dinner" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="event_date" value="Date & Time" />
                        <x-text-input id="event_date" type="datetime-local" name="event_date" :value="old('event_date')" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('event_date')" />
                    </div>
                    <div>
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" :value="old('location')" class="mt-1 block w-full" required placeholder="e.g. UM Gymnasium, Davao City" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>
                </div>
                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="6" placeholder="Describe what this event is about, the schedule, and what attendees should bring or expect." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                <div>
                    <x-input-label for="image" value="Event Image (optional)" />
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-700">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max 4MB.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
                <div class="flex gap-3">
                    <x-primary-button>Create</x-primary-button>
                    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
