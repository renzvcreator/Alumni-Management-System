<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Announcements</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">{{ session('status') }}</div>
            @endif
            <div class="flex justify-end">
                <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">+ New Announcement</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Author</th>
                            <th class="px-4 py-3 text-left">Posted</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $a)
                            <tr class="border-t border-gray-100">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $a->title }}</td>
                                <td class="px-4 py-3">{{ $a->admin->name }}</td>
                                <td class="px-4 py-3">{{ $a->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right space-x-1">
                                    <a href="{{ route('admin.announcements.edit', $a) }}" class="inline-flex items-center px-3 py-1 rounded text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200">Edit</a>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}" class="inline" onsubmit="return confirm('Delete announcement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center px-3 py-1 rounded text-xs font-semibold text-white bg-red-600 hover:bg-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">No announcements yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $announcements->links() }}</div>
        </div>
    </div>
</x-app-layout>
