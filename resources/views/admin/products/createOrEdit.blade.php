@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Create Product')

@section('admin-content')
    <div>
        <x-ui.page-header :title="isset($product) ? 'Edit Product' : 'Create Product'"
            :description="isset($product) ? 'Update product information.' : 'Add a new product to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., Burger Combo"
                        value="{{ old('name', $product->name ?? '') }}" required />

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter product description...">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <x-ui.select name="category_id" label="Category" :value="old('category_id', $product->category_id ?? '')" :options="$categories->pluck('name', 'id')->toArray()" required />

                    <x-ui.input name="slug" type="text" label="Slug"
                        placeholder="e.g., burger-combo (auto-generated if empty)"
                        value="{{ old('slug', $product->slug ?? '') }}" />

                    <x-ui.input name="price" type="number" label="Price" placeholder="e.g., 199.00" step="0.01" min="0"
                        value="{{ old('price', $product->price ?? '') }}" required />

                    <x-ui.input name="image_url" type="text" label="Image URL" placeholder="e.g., /images/products/burger.jpg"
                        value="{{ old('image_url', $product->image_url ?? '') }}" />

                    <x-ui.select name="is_available" label="Availability" :value="old('is_available', isset($product) ? (int) $product->is_available : 1)" :options="[
                        1 => 'Available',
                        0 => 'Unavailable',
                    ]" required />

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.products.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($product) ? 'Update Product' : 'Create Product' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

