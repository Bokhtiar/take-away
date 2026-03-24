@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Product Details" description="View product information." />

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $product->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $product->slug }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $product->category?->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ number_format((float) $product->price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Availability</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $product->is_available ? 'Available' : 'Unavailable' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Image URL</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white break-all">{{ $product->image_url ?? 'N/A' }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $product->description ?? 'N/A' }}</dd>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <x-ui.button href="{{ route('admin.products.index') }}" variant="secondary" size="md">Back</x-ui.button>
                <x-ui.button href="{{ route('admin.products.edit', $product->id) }}" variant="primary" size="md">Edit Product</x-ui.button>
            </div>
        </div>
    </div>
@endsection

