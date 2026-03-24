@extends('admin.layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Category Details" description="View category information." />

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $category->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $category->slug }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        @if ($category->status)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">Active</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">Inactive</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $category->created_at->format('M d, Y h:i A') }}</dd>
                </div>
            </dl>

            <div class="mt-8 flex items-center justify-end gap-3">
                <x-ui.button href="{{ route('admin.categories.index') }}" variant="secondary" size="md">
                    Back
                </x-ui.button>
                <x-ui.button href="{{ route('admin.categories.edit', $category->id) }}" variant="primary" size="md">
                    Edit Category
                </x-ui.button>
            </div>
        </div>
    </div>
@endsection

