<x-app-layout>
    {{-- ========================= HERO ========================= --}}
    <div class="relative isolate overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-indigo-100">
        <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-indigo-300/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-violet-300/30 blur-3xl"></div>

        <div class="mx-auto max-w-4xl px-6 py-20 sm:py-28 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/70 backdrop-blur px-4 py-1.5 text-sm font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200 shadow-sm">
                About Us
            </span>
            <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
                Keeping graduates
                <span class="bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent">connected for life</span>.
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                The Alumni Management System is a secure online community that brings graduates back together, making it easy to find classmates, attend events, and stay in touch with the school long after graduation.
            </p>
        </div>
    </div>



    {{-- ========================= MISSION ========================= --}}
    <div class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 grid gap-12 lg:grid-cols-2 items-center">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Our Mission</h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    We believe the relationship between a school and its graduates should not end at graduation. Our mission is to provide a single, trusted home where alumni can reconnect, support one another, and continue to be part of the community that shaped them.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    By verifying every member and centralizing events, announcements, and messaging, we make it safe and effortless to stay involved, no scattered group chats, no outdated contact lists.
                </p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600 p-8 text-white shadow-lg relative overflow-hidden">
                <div class="pointer-events-none absolute -top-10 -right-10 h-40 w-40 rounded-full bg-white/10"></div>
                <h3 class="text-xl font-semibold relative">Why we built this</h3>
                <ul class="mt-5 space-y-3 relative text-sm text-indigo-50">
                    <li class="flex gap-2"><svg class="w-5 h-5 shrink-0 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Alumni records were scattered and outdated.</li>
                    <li class="flex gap-2"><svg class="w-5 h-5 shrink-0 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Anyone could pose as a graduate on social media.</li>
                    <li class="flex gap-2"><svg class="w-5 h-5 shrink-0 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Event invitations got lost in noisy feeds.</li>
                    <li class="flex gap-2"><svg class="w-5 h-5 shrink-0 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Classmates simply lost touch over time.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ========================= WHAT YOU CAN DO ========================= --}}
    <div class="py-20 bg-gradient-to-b from-white to-indigo-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">What you can do here</h2>
                <p class="mt-3 text-gray-600">Everything you need to stay part of the community.</p>
            </div>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Maintain your profile</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Register as an alumnus and keep your details, job, and graduation year up to date.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Find classmates</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Search the directory by name, graduation year, or industry and reconnect.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">RSVP to events</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Discover reunions and webinars, then reserve your spot in one click.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Read announcements</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Get official news and updates straight from the alumni office.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Message &amp; engage</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Send private messages, and like, bookmark, or poke fellow alumni.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Stay verified &amp; safe</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Every member is reviewed by an admin, so you only connect with real graduates.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= VERIFICATION NOTE ========================= --}}
    <div class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-8 flex gap-5">
                <div class="shrink-0 h-12 w-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-gray-900">A verified, members-only community</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                        New registrations are reviewed by an administrator before gaining access to member features. This keeps the directory authentic and your information visible only to fellow verified alumni &mdash; never to the public.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= CTA ========================= --}}
    @guest
        <div class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600">
            <div class="max-w-3xl mx-auto px-6 py-16 text-center text-white">
                <h2 class="text-3xl font-bold">Ready to reconnect?</h2>
                <p class="mt-3 text-indigo-100">Join your fellow graduates and become part of the community today.</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <button type="button" @click="$store.auth.open('register')"
                            class="inline-flex items-center gap-2 px-7 py-3.5 rounded-md text-base font-semibold text-indigo-700 bg-white hover:bg-indigo-50 shadow-lg transition hover:-translate-y-0.5">
                        Join the Network
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                    <button type="button" @click="$store.auth.open('login')"
                            class="inline-flex items-center px-7 py-3.5 rounded-md text-base font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/30 transition">
                        Sign In
                    </button>
                </div>
            </div>
        </div>
    @endguest
</x-app-layout>
