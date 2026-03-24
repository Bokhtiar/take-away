@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Categories" description="Manage category list for admin panel." />

        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <strong class="font-bold text-lg">Total Categories:</strong>
                <span class="font-semibold">{{ $categories->total() }}</span>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center gap-3" id="searchForm">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Search categories..."
                            class="h-11 w-64 pl-10 pr-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                   placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                    </div>

                    @if (request('search'))
                        <a href="{{ route('admin.categories.index') }}"
                            class="h-11 px-4 flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all"
                            title="Clear search">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </form>

                <x-ui.button href="{{ route('admin.categories.create') }}" variant="primary" size="md" class="rounded-xl h-11">
                    <i class="ri-add-line w-4 h-4 mr-2"></i>
                    Add Category
                </x-ui.button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">Name</th>
                            <th class="px-6 py-3 font-semibold text-left">Slug</th>
                            <th class="px-6 py-3 font-semibold text-left">Status</th>
                            <th class="px-6 py-3 font-semibold text-left">Created</th>
                            <th class="px-6 py-3 font-semibold text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                        {{ $category->slug }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($category->status)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $category->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="show-icon-button" title="View">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="edit-icon-button" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-icon-button" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="ri-inbox-line w-12 h-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="font-medium">No categories found</p>
                                        <p class="text-sm">Create a new category to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

