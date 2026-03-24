@extends('admin.layouts.app')

@section('title', 'Addon Details')
@section('page-title', 'Addon Details')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Addon Details" description="View addon information." />

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $addon->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ number_format((float) $addon->price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $addon->created_at->format('M d, Y h:i A') }}</dd>
                </div>
            </dl>

            <div class="mt-8 flex items-center justify-end gap-3">
                <x-ui.button href="{{ route('admin.addons.index') }}" variant="secondary" size="md">Back</x-ui.button>
                <x-ui.button href="{{ route('admin.addons.edit', $addon->id) }}" variant="primary" size="md">Edit Addon</x-ui.button>
            </div>
        </div>
    </div>
@endsection

