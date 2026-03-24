@extends('admin.layouts.app')

@section('title', 'Admins')
@section('page-title', 'Admins')

@section('admin-content')
    <div class="space-y-6">

        <!-- Header -->
        <x-ui.page-header title="Admins" description="Manage admin users and their roles." />

        <!-- Action Bar -->
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <strong class="font-bold text-lg">Total Admins:</strong> <span
                    class="font-semibold">{{ $admins->total() }}</span>
            </div>

            <div class="flex items-center gap-3">

                <!-- Combined Filter Form -->
                <form method="GET" action="{{ route('admin.admins.index') }}" class="flex items-center gap-3" id="searchForm">
                    <!-- Role Filter -->
                    <select name="role_id" 
                            onchange="this.form.submit()"
                            class="h-11 w-64 px-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                        <option value="">All Roles</option>
                        @foreach(\App\Models\AdminRole::orderBy('name')->get() as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Search Input -->
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               value="{{ request('search') }}" 
                               placeholder="Search admins..."
                               class="h-11 w-64 pl-10 pr-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl 
                                      bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                                      placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Clear Button (if filters active) -->
                    @if(request('search') || request('role_id'))
                        <a href="{{ route('admin.admins.index') }}" 
                           class="h-11 px-4 flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all"
                           title="Clear filters">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </form>

                @can('admins.create')
                    <a href="{{ route('admin.admins.create') }}" 
                       class="inline-flex items-center px-4 py-2.5 h-11 bg-blue-600 hover:bg-blue-700 
                              text-white font-medium rounded-xl transition-colors">
                        <i class="ri-add-line w-4 h-4 mr-2"></i>
                        Add Admin
                    </a>
                @endcan
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
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Email</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Phone</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Role</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Created</th>
                            <th class="px-6 py-3 font-semibold" style="text-align:left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($admins as $admin)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $admin->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $admin->email }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $admin->phone ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 
                                         dark:bg-blue-900/40 dark:text-blue-300">
                                        {{ $admin->role->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $admin->created_at->format('M d, Y') }}
                                </td>

                                <!-- Actions (with permission checks) -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        @can('admins.view')
                                            <a href="{{ route('admin.admins.show', $admin->id) }}" class="show-icon-button" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('admins.edit')
                                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="edit-icon-button" title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('admins.delete')
                                            <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" onsubmit="return confirm('Sure?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="delete-icon-button" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="ri-inbox-line w-12 h-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="font-medium">No admins found</p>
                                        <p class="text-sm">Create a new admin to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($admins->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60">
                    {{ $admins->links() }}
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
                // Clear the previous timeout if user is still typing
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                
                // Set a new timeout to submit the form after 1 second of inactivity
                searchTimeout = setTimeout(function() {
                    searchForm.submit();
                }, 1000);
            });

            // Also allow immediate search on Enter key press
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    
                    // Clear any pending timeout
                    if (searchTimeout) {
                        clearTimeout(searchTimeout);
                    }
                    
                    // Submit the form immediately
                    searchForm.submit();
                }
            });
        }
    });
</script>
@endpush

