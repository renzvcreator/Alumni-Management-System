<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Privacy Policy</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-xl p-8 space-y-6 text-gray-700 leading-relaxed">
                <div>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md px-3 py-1.5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </a>
                </div>

                <h1 class="text-2xl font-bold text-gray-900">Privacy Policy</h1>
                <p class="text-sm text-gray-500">Last updated: {{ date('F j, Y') }}</p>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">1. Information We Collect</h2>
                    <p class="mt-2">When you register for the Alumni Management System, we collect your name, email address, graduation year, current job, industry, contact number, and an optional profile picture. All of this information is voluntarily provided by you during registration or when you update your profile.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">2. How We Use Your Information</h2>
                    <p class="mt-2">Your information is used to verify your alumni status, populate the alumni directory, notify you about announcements and events, and enable communication with other approved alumni through messaging and profile interactions.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">3. Who Can See Your Profile</h2>
                    <p class="mt-2">Only other approved alumni and administrators can view your profile in the directory. Your email and contact number are visible on your profile page; you may leave optional fields blank if you prefer not to share them.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">4. Data Security</h2>
                    <p class="mt-2">Passwords are hashed before being stored. All registrations go through an approval process by an administrator before the account is activated. You may request removal of your account by contacting the alumni office.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">5. Your Rights</h2>
                    <p class="mt-2">You can edit your profile information at any time, bookmark and unbookmark profiles, and opt out of communication by logging out or requesting account deletion. We do not sell or share your information with third parties.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">6. Contact</h2>
                    <p class="mt-2">For privacy-related questions, contact me at <a href="mailto:R.varron.557346@umindanao.edu.ph" class="text-indigo-700 underline">R.varron.557346@umindanao.edu.ph</a>.</p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
