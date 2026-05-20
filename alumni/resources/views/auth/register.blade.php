<x-guest-layout>
    <div class="mb-4">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Home
        </a>
    </div>

    <h2 class="text-xl font-semibold mb-4 text-gray-900">Create your Alumni Account</h2>
    <p class="text-sm text-gray-600 mb-6">Fill out your details below. Your account will be reviewed by an administrator before activation.</p>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        @include('partials.register-fields')

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
