<x-app-layout>
    {{-- ========================= HERO ========================= --}}
    <div class="relative isolate overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-indigo-100">
        {{-- decorative blurred blobs --}}
        <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-indigo-300/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-violet-300/30 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 -z-10 opacity-[0.04]"
             style="background-image:linear-gradient(#4f46e5 1px,transparent 1px),linear-gradient(90deg,#4f46e5 1px,transparent 1px);background-size:42px 42px;"></div>

        <div class="mx-auto max-w-5xl px-6 py-24 sm:py-32 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/70 backdrop-blur px-4 py-1.5 text-sm font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Alumni Network System
            </span>

            <h1 class="mt-6 text-4xl sm:text-6xl font-bold tracking-tight text-gray-900">
                Where graduates
                <span class="bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent">stay connected</span>.
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                Reconnect with classmates, discover reunions and events, and never miss an update from your alma mater, all in one secure, verified community.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-x-4 gap-y-3">
                @guest
                    <button type="button" @click="$store.auth.open('register')"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5">
                        Join the Network
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                    <button type="button" @click="$store.auth.open('login')"
                            class="inline-flex items-center px-6 py-3 rounded-md text-base font-semibold text-indigo-700 bg-white border border-indigo-200 hover:bg-indigo-50 shadow-sm transition">
                        Sign In
                    </button>
                @else
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 rounded-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow">Go to Dashboard</a>
                @endguest
            </div>

            <p class="mt-4 text-sm text-gray-500">Free for all verified graduates</p>

            {{-- live stats strip --}}
            <div class="mx-auto mt-14 grid max-w-2xl grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white/70 backdrop-blur px-4 py-6 ring-1 ring-inset ring-gray-200 shadow-sm">
                    <div class="text-3xl sm:text-4xl font-bold text-indigo-700">{{ number_format($stats['alumni']) }}+</div>
                    <div class="mt-1 text-xs sm:text-sm font-medium text-gray-500">Registered Alumni</div>
                </div>
                <div class="rounded-2xl bg-white/70 backdrop-blur px-4 py-6 ring-1 ring-inset ring-gray-200 shadow-sm">
                    <div class="text-3xl sm:text-4xl font-bold text-indigo-700">{{ number_format($stats['events']) }}</div>
                    <div class="mt-1 text-xs sm:text-sm font-medium text-gray-500">Events Hosted</div>
                </div>
                <div class="rounded-2xl bg-white/70 backdrop-blur px-4 py-6 ring-1 ring-inset ring-gray-200 shadow-sm">
                    <div class="text-3xl sm:text-4xl font-bold text-indigo-700">{{ number_format($stats['announcements']) }}</div>
                    <div class="mt-1 text-xs sm:text-sm font-medium text-gray-500">Announcements</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= FEATURES ========================= --}}
    <div class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Everything you need to stay in the loop</h2>
                <p class="mt-3 text-gray-600">One platform built specifically for our alumni community.</p>
            </div>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Directory --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Alumni Directory</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Search and reconnect with fellow graduates by name, graduation year, or industry.</p>
                </div>

                {{-- Events --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Events &amp; RSVP</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Discover reunions, webinars, and networking nights, then RSVP in a single click.</p>
                </div>

                {{-- Announcements --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Announcements</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Stay in the loop with official news and updates curated by the alumni office.</p>
                </div>

                {{-- Messaging --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Direct Messaging</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Send private messages to batchmates and rebuild the connections that matter.</p>
                </div>

                {{-- Verified --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Verified Community</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Every member is reviewed by an administrator, so you only connect with real alumni.</p>
                </div>

                {{-- Engage --}}
                <div class="group p-7 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
                    <div class="h-12 w-12 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                    </div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Likes &amp; Bookmarks</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">Like, bookmark, and poke profiles to keep track of the people you want to reach out to.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= HOW IT WORKS ========================= --}}
    <div class="py-20 bg-gradient-to-b from-white to-indigo-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Get started in three steps</h2>
                <p class="mt-3 text-gray-600">Joining the alumni community takes just a few minutes.</p>
            </div>

            <div class="mt-14 grid gap-8 sm:grid-cols-3">
                <div class="relative text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-indigo-600 text-white text-xl font-bold flex items-center justify-center shadow-lg shadow-indigo-600/30">1</div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Register</h3>
                    <p class="mt-2 text-gray-600 text-sm">Sign up and upload a document that proves you graduated.</p>
                </div>
                <div class="relative text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-indigo-600 text-white text-xl font-bold flex items-center justify-center shadow-lg shadow-indigo-600/30">2</div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Get Verified</h3>
                    <p class="mt-2 text-gray-600 text-sm">An administrator reviews your document and approves your account.</p>
                </div>
                <div class="relative text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-indigo-600 text-white text-xl font-bold flex items-center justify-center shadow-lg shadow-indigo-600/30">3</div>
                    <h3 class="mt-5 font-semibold text-lg text-gray-900">Connect</h3>
                    <p class="mt-2 text-gray-600 text-sm">Explore the directory, RSVP to events, and start reconnecting.</p>
                </div>
            </div>

            @guest
                <div class="mt-14 text-center">
                    <button type="button" @click="$store.auth.open('register')"
                            class="inline-flex items-center gap-2 px-7 py-3.5 rounded-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5">
                        Create your account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                </div>
            @endguest
        </div>
    </div>

    {{-- ========================= FOOTER ========================= --}}
    <footer class="bg-indigo-900 text-indigo-100">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="grid gap-10 md:grid-cols-3">
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                        <span class="text-lg font-semibold text-white">Alumni</span>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-indigo-200">
                        Connect with fellow graduates and stay updated with the latest news and events.
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Quick Links</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-indigo-200 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-indigo-200 hover:text-white transition">About</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Contact Us</h4>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-indigo-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:R.varron.557346@umindanao.edu.ph" class="text-indigo-200 hover:text-white break-all transition">R.varron.557346@umindanao.edu.ph</a>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-indigo-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.45 1.9L8.09 10.91a11 11 0 005 5l1.695-1.38a2 2 0 011.9-.45l2.8.7A2 2 0 0121 16.72V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V6z"/></svg>
                            <a href="tel:09622495710" class="text-indigo-200 hover:text-white transition">09622495710</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-indigo-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-indigo-300">
                <p>&copy; {{ date('Y') }} Alumni Management System. All rights reserved.</p>
                <p>Built with Laravel 12, PHP 8, Tailwind CSS, Alpine.js, and MySQL.</p>
            </div>
        </div>
    </footer>
</x-app-layout>
