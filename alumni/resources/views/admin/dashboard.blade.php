<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Pending</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['approved'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Approved</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-red-600">{{ $stats['blocked'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Blocked</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['events'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Events</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['announcements'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Announcements</div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pending Approvals</h3>
                    <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="text-sm text-indigo-600 hover:underline">Manage all</a>
                </div>

                @if ($recentPending->isEmpty())
                    <p class="text-sm text-gray-500">No pending registrations.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 uppercase">
                                <th class="py-2">Name</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Graduation</th>
                                <th class="py-2">Document</th>
                                <th class="py-2">Registered</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPending as $u)
                                <tr class="border-t border-gray-100">
                                    <td class="py-3">{{ $u->profile?->full_name ?? $u->name }}</td>
                                    <td class="py-3">{{ $u->email }}</td>
                                    <td class="py-3">{{ $u->profile?->graduation_year ?? '—' }}</td>
                                    <td class="py-3">
                                        @if ($u->verification_document_path)
                                            <a href="{{ $u->verification_document_path }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-700 hover:underline text-xs font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                View
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $u->created_at->diffForHumans() }}</td>
                                    <td class="py-3 text-right space-x-2 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                            @csrf
                                            <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject', $u) }}" class="inline" onsubmit="return confirm('Reject this registration?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-red-600 hover:bg-red-700">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
