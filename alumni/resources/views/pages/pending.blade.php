<x-app-layout>
    <div class="min-h-[60vh] flex items-center">
        <div class="max-w-xl mx-auto text-center px-6 py-12">
            <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-amber-100">
                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="mt-6 text-3xl font-bold text-gray-900">Waiting for Approval</h1>
            <p class="mt-4 text-gray-600">
                Thanks for registering, {{ Auth::user()->name }}! Your account is pending review by the
                admin. You'll be able to access the directory, events, and announcements once an
                administrator approves your registration.
            </p>
            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="inline-flex items-center px-5 py-3 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">Log Out</button>
            </form>
        </div>
    </div>
</x-app-layout>
