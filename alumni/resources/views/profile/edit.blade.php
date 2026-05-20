<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('My Account') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================== PROFILE HEADER ===================== --}}
            <div class="bg-white shadow rounded-2xl overflow-hidden ring-1 ring-gray-100">
                <div class="relative h-28 bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600">
                    <div class="pointer-events-none absolute -top-8 -right-8 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="pointer-events-none absolute -bottom-10 -left-6 h-28 w-28 rounded-full bg-white/10"></div>
                </div>
                <div class="relative px-6 sm:px-8 pb-6">
                    {{-- Avatar overlaps the banner; text sits below to avoid overlap --}}
                    <div class="-mt-12">
                        @if ($profile?->profile_picture_url)
                            <img src="{{ $profile->profile_picture_url }}" class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-md">
                        @else
                            <div class="h-24 w-24 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-3xl font-bold ring-4 ring-white shadow-md">
                                {{ strtoupper(substr($profile?->first_name ?? $user->name, 0, 1) . substr($profile?->last_name ?? '', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="min-w-0">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $profile?->full_name ?? $user->name }}</h1>
                            <p class="text-sm text-gray-500 mt-0.5">
                                @if ($profile?->graduation_year) Class of {{ $profile->graduation_year }} @endif
                                @if ($profile?->industry) · {{ $profile->industry }} @endif
                            </p>
                            <p class="text-sm text-gray-400 mt-0.5 break-all">{{ $user->email }}</p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('directory.show', $user) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                View public profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                {{-- ===================== SIDEBAR NAV ===================== --}}
                <aside class="lg:col-span-1">
                    <nav class="lg:sticky lg:top-24 bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl p-2">
                        <a href="#profile-information" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-indigo-50 text-gray-700 hover:text-indigo-700 transition">
                            <span class="h-9 w-9 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <div class="text-sm font-semibold">Profile Information</div>
                                <div class="text-xs text-gray-400">Name, contact, picture</div>
                            </div>
                        </a>
                        <a href="#security" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-indigo-50 text-gray-700 hover:text-indigo-700 transition">
                            <span class="h-9 w-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </span>
                            <div>
                                <div class="text-sm font-semibold">Security</div>
                                <div class="text-xs text-gray-400">Change password</div>
                            </div>
                        </a>
                        <a href="#danger-zone" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-gray-700 hover:text-red-700 transition">
                            <span class="h-9 w-9 rounded-lg bg-red-100 text-red-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </span>
                            <div>
                                <div class="text-sm font-semibold">Danger Zone</div>
                                <div class="text-xs text-gray-400">Delete account</div>
                            </div>
                        </a>
                    </nav>
                </aside>

                {{-- ===================== SECTIONS ===================== --}}
                <div class="lg:col-span-2 space-y-6">
                    <section id="profile-information" class="scroll-mt-24 bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </section>

                    <section id="security" class="scroll-mt-24 bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </section>

                    <section id="danger-zone" class="scroll-mt-24 bg-white shadow-sm ring-1 ring-red-100 rounded-2xl p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
