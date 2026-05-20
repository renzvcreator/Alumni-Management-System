<section>
    <header class="flex items-start gap-3 pb-5 border-b border-gray-100">
        <span class="h-10 w-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </span>
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ __("Update your account's profile and contact information.") }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @if ($profile && $profile->profile_picture_url)
            <div class="flex items-center gap-4">
                <img src="{{ $profile->profile_picture_url }}" alt="Profile picture" class="h-16 w-16 rounded-full object-cover border border-gray-200">
                <span class="text-sm text-gray-600">Current picture</span>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $profile?->first_name)" required placeholder="Juan" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $profile?->middle_name)" placeholder="(Optional)" />
                <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $profile?->last_name)" required placeholder="Dela Cruz" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                <x-text-input id="graduation_year" name="graduation_year" type="number" min="1950" max="{{ date('Y') + 5 }}" class="mt-1 block w-full" :value="old('graduation_year', $profile?->graduation_year)" placeholder="e.g. 2020" />
                <x-input-error class="mt-2" :messages="$errors->get('graduation_year')" />
            </div>
            <div>
                <x-input-label for="current_job" :value="__('Current Job')" />
                <x-text-input id="current_job" name="current_job" type="text" class="mt-1 block w-full" :value="old('current_job', $profile?->current_job)" placeholder="e.g. Software Engineer at Acme Corp" />
                <x-input-error class="mt-2" :messages="$errors->get('current_job')" />
            </div>
            <div>
                <x-input-label for="industry" :value="__('Industry')" />
                <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry', $profile?->industry)" placeholder="e.g. Technology" />
                <x-input-error class="mt-2" :messages="$errors->get('industry')" />
            </div>
        </div>

        <div>
            <x-input-label for="contact_number" :value="__('Contact Number')" />
            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number', $profile?->contact_number)" placeholder="09XX XXX XXXX" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4" placeholder="Tell other alumni about yourself, your achievements, or what you're working on." class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('bio', $profile?->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input id="profile_picture" name="profile_picture" type="file" accept="image/*"
                class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer" />
            <p class="mt-1 text-xs text-gray-400">JPG, PNG, or GIF. Leave empty to keep your current picture.</p>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="inline-flex items-center gap-1 text-sm font-medium text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ __('Saved!') }}
                </p>
            @endif
        </div>
    </form>
</section>
