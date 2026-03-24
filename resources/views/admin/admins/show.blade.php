@extends('admin.layouts.app')

@section('title', 'View Admin')
@section('page-title', 'View Admin')

@section('admin-content')
    <div class="space-y-8 w-full px-4 md:px-8 lg:px-16">
        <!-- Page Header -->
        <x-ui.page-header title="View Admin" description="Detailed information about this admin user." />

        <!-- Admin Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 w-full max-w-full">
            <!-- Action Buttons -->
            <div class="flex flex-wrap justify-end gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <a href="{{ route('admin.admins.edit', $admin->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                    Edit
                </a>
                <a href="{{ route('admin.admins.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                    Back
                </a>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $admin->id }}</p>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Name</label>
                    <p class="text-gray-900 dark:text-white text-lg font-semibold">{{ $admin->name }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                    <p class="text-gray-900 dark:text-white">{{ $admin->email }}</p>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Phone</label>
                    <p class="text-gray-900 dark:text-white">{{ $admin->phone ?? 'N/A' }}</p>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Role</label>
                    <span
                        class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 rounded text-sm font-medium">
                        {{ $admin->role->name ?? 'N/A' }}
                    </span>
                </div>

             
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                    <p class="text-gray-900 dark:text-white">{{ $admin->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Updated At</label>
                    <p class="text-gray-900 dark:text-white">{{ $admin->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection