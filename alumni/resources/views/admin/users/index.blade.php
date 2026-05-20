<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.users.index') }}" class="bg-white shadow sm:rounded-lg p-4 flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <x-input-label for="search" value="Search" />
                    <x-text-input id="search" name="search" :value="$search" class="mt-1 block w-full" placeholder="Search by name or email..." />
                </div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="all" @selected($status==='all')>All</option>
                        <option value="pending" @selected($status==='pending')>Pending</option>
                        <option value="approved" @selected($status==='approved')>Approved</option>
                        <option value="blocked" @selected($status==='blocked')>Blocked</option>
                    </select>
                </div>
                <x-primary-button>Filter</x-primary-button>
            </form>

            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Graduation</th>
                            <th class="px-4 py-3 text-left">Document</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr class="border-t border-gray-100">
                                <td class="px-4 py-3">{{ $u->profile?->full_name ?? $u->name }}</td>
                                <td class="px-4 py-3">{{ $u->email }}</td>
                                <td class="px-4 py-3">{{ $u->profile?->graduation_year ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($u->verification_document_path)
                                        <a href="{{ $u->verification_document_path }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-700 hover:underline text-xs font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            View
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'blocked' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs {{ $colors[$u->status] ?? '' }}">{{ ucfirst($u->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-right space-x-1">
                                    @php
                                        $btnApprove = 'inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700';
                                        $btnReject = 'inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-red-600 hover:bg-red-700';
                                        $btnBlock = 'inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700';
                                        $btnDelete = 'inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-gray-700 hover:bg-gray-800';
                                    @endphp
                                    @if ($u->status === 'pending')
                                        <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                            @csrf
                                            <button class="{{ $btnApprove }}">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject', $u) }}" class="inline" onsubmit="return confirm('Reject {{ $u->email }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="{{ $btnReject }}">Reject</button>
                                        </form>
                                    @elseif ($u->status === 'approved')
                                        <form method="POST" action="{{ route('admin.users.block', $u) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="{{ $btnBlock }}">Block</button>
                                        </form>
                                    @elseif ($u->status === 'blocked')
                                        <form method="POST" action="{{ route('admin.users.unblock', $u) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="{{ $btnApprove }}">Unblock</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Delete {{ $u->email }} permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="{{ $btnDelete }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
