@php
    // Decide which modal (if any) should be auto-opened after a failed submit.
    $registerErrors = $errors->has('first_name') || $errors->has('last_name')
        || $errors->has('verification_document') || $errors->has('privacy')
        || $errors->has('password_confirmation');
    $loginErrors = ! $registerErrors && ($errors->has('email') || $errors->has('password'));

    $autoOpen = null;
    if ($registerErrors || old('first_name')) {
        $autoOpen = 'register';
    } elseif ($loginErrors) {
        $autoOpen = 'login';
    }

    $iconInput = 'block w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm';
@endphp

<div x-data x-init="@if($autoOpen) $store.auth.open('{{ $autoOpen }}') @endif"
     x-show="$store.auth.modal !== null"
     x-cloak
     @keydown.escape.window="$store.auth.close()"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="$store.auth.close()"></div>

    {{-- ============================ LOGIN MODAL ============================ --}}
    <div x-show="$store.auth.modal === 'login'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="relative bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden grid sm:grid-cols-2">

        <button type="button" @click="$store.auth.close()"
                class="absolute top-4 right-4 z-20 p-1.5 rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 sm:text-white/80 sm:hover:text-white sm:hover:bg-white/15"
                aria-label="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        {{-- Brand panel --}}
        <div class="hidden sm:flex relative flex-col justify-between bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600 p-8 text-white overflow-hidden">
            <div class="pointer-events-none absolute -top-10 -right-10 h-40 w-40 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-12 -left-10 h-44 w-44 rounded-full bg-white/10"></div>

            <div class="relative flex items-center gap-2">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                <span class="text-lg font-semibold">Alumni</span>
            </div>

            <div class="relative">
                <h3 class="text-2xl font-bold leading-snug">Welcome back to your alumni community.</h3>
                <p class="mt-3 text-indigo-100 text-sm leading-relaxed">Sign in to reconnect with classmates, RSVP to events, and catch up on the latest news.</p>
            </div>

            <ul class="relative space-y-2.5 text-sm text-indigo-50">
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Find and message batchmates</li>
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> RSVP to reunions and events</li>
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Never miss an announcement</li>
            </ul>
        </div>

        {{-- Form panel --}}
        <div class="p-6 sm:p-8" x-data="{ submitting: false }">
            <h3 class="text-xl font-bold text-gray-900">Sign in</h3>
            <p class="mt-1 text-sm text-gray-500">Enter your credentials to continue.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4" @submit="submitting = true">
                @csrf
                @if (session('status'))
                    <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-2 text-sm">{{ session('status') }}</div>
                @endif

                <div>
                    <x-input-label for="login_email" :value="__('Email')" />
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </span>
                        <input id="login_email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="{{ $iconInput }}">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div x-data="{ show: false }">
                    <x-input-label for="login_password" :value="__('Password')" />
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </span>
                        <input id="login_password" name="password" required autocomplete="current-password"
                               :type="show ? 'text' : 'password'"
                               class="{{ $iconInput }} pr-10">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
                                :aria-label="show ? 'Hide password' : 'Show password'">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"/></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-700 hover:underline">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" :disabled="submitting"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/20 disabled:opacity-70 disabled:cursor-not-allowed transition">
                    <svg x-show="submitting" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="submitting ? 'Signing in...' : 'Sign in'">Sign in</span>
                </button>

                <p class="text-center text-sm text-gray-600">
                    Don't have an account?
                    <button type="button" @click="$store.auth.modal = 'register'" class="font-semibold text-indigo-700 hover:underline">Sign up</button>
                </p>
            </form>
        </div>
    </div>

    {{-- ============================ REGISTER MODAL ============================ --}}
    <div x-show="$store.auth.modal === 'register'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden grid sm:grid-cols-5 max-h-[92vh]">

        <button type="button" @click="$store.auth.close()"
                class="absolute top-4 right-4 z-20 p-1.5 rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100"
                aria-label="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        {{-- Brand panel --}}
        <div class="hidden sm:flex sm:col-span-2 relative flex-col justify-between bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600 p-8 text-white overflow-hidden">
            <div class="pointer-events-none absolute -top-10 -right-10 h-40 w-40 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-10 h-48 w-48 rounded-full bg-white/10"></div>

            <div class="relative flex items-center gap-2">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                <span class="text-lg font-semibold">Alumni</span>
            </div>

            <div class="relative">
                <h3 class="text-2xl font-bold leading-snug">Join the network in three steps.</h3>
                <ol class="mt-5 space-y-4">
                    <li class="flex gap-3">
                        <span class="shrink-0 h-7 w-7 rounded-full bg-white/15 ring-1 ring-white/30 flex items-center justify-center text-sm font-bold">1</span>
                        <div><p class="text-sm font-semibold">Fill in your details</p><p class="text-xs text-indigo-100">Tell us who you are and when you graduated.</p></div>
                    </li>
                    <li class="flex gap-3">
                        <span class="shrink-0 h-7 w-7 rounded-full bg-white/15 ring-1 ring-white/30 flex items-center justify-center text-sm font-bold">2</span>
                        <div><p class="text-sm font-semibold">Upload proof</p><p class="text-xs text-indigo-100">Attach a document confirming you graduated.</p></div>
                    </li>
                    <li class="flex gap-3">
                        <span class="shrink-0 h-7 w-7 rounded-full bg-white/15 ring-1 ring-white/30 flex items-center justify-center text-sm font-bold">3</span>
                        <div><p class="text-sm font-semibold">Get approved</p><p class="text-xs text-indigo-100">An admin reviews and activates your account.</p></div>
                    </li>
                </ol>
            </div>

            <p class="relative text-xs text-indigo-100">Already a member?
                <button type="button" @click="$store.auth.modal = 'login'" class="font-semibold text-white underline">Sign in instead</button>
            </p>
        </div>

        {{-- Form panel --}}
        <div class="sm:col-span-3 flex flex-col max-h-[92vh]" x-data="{ submitting: false }">
            <div class="px-6 pt-6 pb-2 shrink-0">
                <h3 class="text-xl font-bold text-gray-900">Create your alumni account</h3>
                <p class="mt-1 text-sm text-gray-500">Your account will be reviewed by an administrator before activation.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                  class="px-6 pb-6 space-y-1 overflow-y-auto" @submit="submitting = true">
                @csrf

                @include('partials.register-fields')

                <div class="pt-5">
                    <button type="submit" :disabled="submitting"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-indigo-600/20 disabled:opacity-70 disabled:cursor-not-allowed transition">
                        <svg x-show="submitting" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <span x-text="submitting ? 'Creating account...' : 'Create account'">Create account</span>
                    </button>
                    <p class="mt-3 text-center text-sm text-gray-600 sm:hidden">
                        Already have an account?
                        <button type="button" @click="$store.auth.modal = 'login'" class="font-semibold text-indigo-700 hover:underline">Log in</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
