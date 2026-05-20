@php
    $eyeBtn = 'absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700';
    $pwInput = 'block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10';
@endphp

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <x-input-label for="first_name" :value="__('First Name')" />
        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus placeholder="" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="middle_name" :value="__('Middle Name')" />
        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" placeholder="(Optional)" />
        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="last_name" :value="__('Last Name')" />
        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required placeholder="" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
    <div>
        <x-input-label for="graduation_year" :value="__('Graduation Year')" />
        <x-text-input id="graduation_year" class="block mt-1 w-full" type="number" name="graduation_year" :value="old('graduation_year')" min="1950" max="{{ date('Y') + 5 }}" placeholder="" />
        <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="current_job" :value="__('Current Job')" />
        <x-text-input id="current_job" class="block mt-1 w-full" type="text" name="current_job" :value="old('current_job')" placeholder="" />
        <x-input-error :messages="$errors->get('current_job')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="industry" :value="__('Industry')" />
        <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" :value="old('industry')" placeholder="" />
        <x-input-error :messages="$errors->get('industry')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="contact_number" :value="__('Contact Number')" />
        <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number')" placeholder="" />
        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>

<div x-data="{
        pw: '',
        pwc: '',
        showPw: false,
        showPwc: false,
        score() {
            let s = 0;
            if (this.pw.length >= 8) s++;
            if (/[A-Z]/.test(this.pw) && /[a-z]/.test(this.pw)) s++;
            if (/[0-9]/.test(this.pw)) s++;
            if (/[^A-Za-z0-9]/.test(this.pw)) s++;
            return s;
        },
        label() { return ['Too weak', 'Weak', 'Fair', 'Good', 'Strong'][this.score()]; },
        barColor() { return ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-lime-500', 'bg-emerald-500'][this.score()]; },
        textColor() { return ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-lime-600', 'text-emerald-600'][this.score()]; }
     }"
     class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="password" :value="__('Password')" />
        <div class="relative mt-1">
            <input id="password" name="password" required autocomplete="new-password" x-model="pw"
                :type="showPw ? 'text' : 'password'" placeholder="At least 8 characters" class="{{ $pwInput }}">
            <button type="button" @click="showPw = !showPw" class="{{ $eyeBtn }}" :aria-label="showPw ? 'Hide password' : 'Show password'">
                <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"/></svg>
            </button>
        </div>
        {{-- password strength meter --}}
        <div x-show="pw.length > 0" x-cloak class="mt-2">
            <div class="flex gap-1">
                <template x-for="i in 4" :key="i">
                    <div class="h-1.5 flex-1 rounded-full transition-colors" :class="i <= score() ? barColor() : 'bg-gray-200'"></div>
                </template>
            </div>
            <p class="mt-1 text-xs font-medium" :class="textColor()" x-text="'Password strength: ' + label()"></p>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <div class="relative mt-1">
            <input id="password_confirmation" name="password_confirmation" required autocomplete="new-password" x-model="pwc"
                :type="showPwc ? 'text' : 'password'" placeholder="Re-enter your password" class="{{ $pwInput }}">
            <button type="button" @click="showPwc = !showPwc" class="{{ $eyeBtn }}" :aria-label="showPwc ? 'Hide password' : 'Show password'">
                <svg x-show="!showPwc" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <svg x-show="showPwc" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"/></svg>
            </button>
        </div>
        {{-- match indicator --}}
        <p x-show="pwc.length > 0" x-cloak class="mt-1 text-xs font-medium"
           :class="pw === pwc ? 'text-emerald-600' : 'text-red-600'"
           x-text="pw === pwc ? 'Passwords match' : 'Passwords do not match'"></p>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
</div>

<div class="mt-4 p-4 rounded-lg bg-indigo-50 border border-indigo-100">
    <x-input-label for="verification_document" value="Verification Document" class="text-gray-900 font-semibold" />
    <p class="text-xs text-gray-600 mt-1">
        Upload a photo of your <strong>Certificate of Completion</strong>, <strong>School ID</strong>, or any document
        proving you are an alumnus of the school. This will be reviewed by an administrator before your account is approved.
    </p>
    <input id="verification_document" name="verification_document" type="file" accept="image/*,.pdf" required
        class="mt-3 block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
    <p class="text-xs text-gray-500 mt-2">JPG, PNG, or PDF. Max 4MB.</p>
    <x-input-error :messages="$errors->get('verification_document')" class="mt-2" />
</div>

<div class="mt-4">
    <label for="privacy" class="flex items-start gap-2">
        <input id="privacy" type="checkbox" name="privacy" value="1" {{ old('privacy') ? 'checked' : '' }} required class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
        <span class="text-sm text-gray-600">
            I have read and agree to the
            <a href="{{ route('privacy') }}" target="_blank" class="text-indigo-700 underline hover:text-indigo-900">Privacy Policy</a>.
        </span>
    </label>
    <x-input-error :messages="$errors->get('privacy')" class="mt-2" />
</div>
