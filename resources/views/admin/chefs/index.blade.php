@extends('admin.layouts.app')

@section('title', 'Chefs')
@section('page-title', 'Chefs')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Chefs" description="Manage chef profiles for restaurant admin." />

        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <strong class="font-bold text-lg">Total Chefs:</strong>
                <span class="font-semibold">{{ $chefs->total() }}</span>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.chefs.index') }}" class="flex items-center gap-3" id="searchForm">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Search chefs..."
                            class="h-11 w-64 pl-10 pr-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                    </div>
                </form>

                <x-ui.button href="{{ route('admin.chefs.create') }}" variant="primary" size="md" class="rounded-xl h-11">
                    <i class="ri-add-line w-4 h-4 mr-2"></i>
                    Add Chef
                </x-ui.button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">Name</th>
                            <th class="px-6 py-3 font-semibold text-left">Designation</th>
                            <th class="px-6 py-3 font-semibold text-left">Phone</th>
                            <th class="px-6 py-3 font-semibold text-left">Created</th>
                            <th class="px-6 py-3 font-semibold text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($chefs as $chef)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $chef->name }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $chef->designation }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $chef->phone }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $chef->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.chefs.show', $chef->id) }}" class="show-icon-button" title="View"><i class="ri-eye-line"></i></a>
                                        <a href="{{ route('admin.chefs.edit', $chef->id) }}" class="edit-icon-button" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <form method="POST" action="{{ route('admin.chefs.destroy', $chef->id) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-icon-button" title="Delete"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">No chefs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($chefs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60">
                    {{ $chefs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

