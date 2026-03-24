@extends('admin.layouts.app')

@section('title', 'Admin Menus')
@section('page-title', 'Admin Menus')

@section('admin-content')
    <div class="space-y-6">

        <!-- Header -->
        <x-ui.page-header title="Admin Menus" description="Manage navigation menus and menu structure." />

        <!-- Action Bar -->
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <strong class="font-bold text-lg">Total Menus:</strong> <span
                    class="font-semibold">{{ $adminMenus->total() }}</span>
            </div>

            <div class="flex items-center gap-3">

                <!-- Combined Filter Form -->
                <form method="GET" action="{{ route('admin.admin-menus.index') }}" class="flex items-center gap-3" id="searchForm">
                    <!-- Parent Menu Filter -->
                    <select name="parent_id" 
                            onchange="this.form.submit()"
                            class="h-11 w-64 px-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                        <option value="">All Menus</option>
                        <option value="root" {{ request('parent_id') == 'root' ? 'selected' : '' }}>Root Menus Only</option>
                        @foreach(\App\Models\AdminMenu::parents()->ordered()->get() as $parentMenu)
                            <option value="{{ $parentMenu->id }}" {{ request('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                                {{ $parentMenu->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Search Input -->
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               value="{{ request('search') }}" 
                               placeholder="Search menus..."
                               class="h-11 w-64 pl-10 pr-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl 
                                      bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                                      placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Clear Button (if filters active) -->
                    @if(request('search') || request('parent_id'))
                        <a href="{{ route('admin.admin-menus.index') }}" 
                           class="h-11 px-4 flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all"
                           title="Clear filters">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </form>

                <!-- Add Button -->
                <x-ui.button href="{{ route('admin.admin-menus.create') }}" variant="primary" size="md"
                    class="rounded-xl h-11">
                    <i class="ri-add-line w-4 h-4 mr-2"></i>
                    Add Menu
                </x-ui.button>
            </div>
        </div>

        <!-- Table -->
        <div
            class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Name</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Slug</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Icon</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Parent</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Order</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Status</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($adminMenus as $menu)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $menu->name }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 
                                         dark:bg-gray-700 dark:text-gray-300">
                                        {{ $menu->slug }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }} text-lg"></i>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $menu->parent->name ?? 'Root' }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $menu->sort_order }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($menu->is_active)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 
                                                     dark:bg-green-900/40 dark:text-green-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 
                                                     dark:bg-red-900/40 dark:text-red-300">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 ">
                                    <div class="flex items-center gap-1">

                                        <!-- View -->
                                        <a href="{{ route('admin.admin-menus.show', $menu->id) }}"
                                            class="show-icon-button"
                                            title="View">
                                            <i class="ri-eye-line "></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.admin-menus.edit', $menu->id) }}"
                                            class="edit-icon-button"
                                            title="Edit">
                                            <i class="ri-pencil-line "></i>
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('admin.admin-menus.destroy', $menu->id) }}"
                                            onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="delete-icon-button"
                                                title="Delete">
                                                <i class="ri-delete-bin-line "></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="ri-inbox-line w-12 h-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="font-medium">No menus found</p>
                                        <p class="text-sm">Create a new menu to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($adminMenus->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60">
                    {{ $adminMenus->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

@push('admin-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let searchTimeout = null;

        if (searchInput && searchForm) {
            // Only auto-select if input has value
            if (searchInput.value && searchInput.value.trim() !== '') {
                searchInput.focus();
                searchInput.select(); // Select all text
            }

            searchInput.addEventListener('input', function(event) {
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                
                searchTimeout = setTimeout(function() {
                    searchForm.submit();
                }, 1000);
            });

            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    
                    if (searchTimeout) {
                        clearTimeout(searchTimeout);
                    }
                    
                    searchForm.submit();
                }
            });
        }
    });
</script>
@endpush

