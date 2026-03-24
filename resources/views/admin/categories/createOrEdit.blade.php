@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')
@section('page-title', isset($category) ? 'Edit Category' : 'Create Category')

@section('admin-content')
    <div>
        <x-ui.page-header :title="isset($category) ? 'Edit Category' : 'Create Category'"
            :description="isset($category) ? 'Update category information.' : 'Add a new category to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($category))
                        @method('PUT')
                    @endif

                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., Beverages"
                        value="{{ old('name', $category->name ?? '') }}" required />

                    <x-ui.input name="slug" type="text" label="Slug"
                        placeholder="e.g., beverages (auto-generated if empty)"
                        value="{{ old('slug', $category->slug ?? '') }}" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Leave empty to auto-generate from name.</p>

                    <x-ui.select name="status" label="Status" :value="old('status', isset($category) ? (int) $category->status : 1)" :options="[
                        ['value' => 1, 'label' => 'Active'],
                        ['value' => 0, 'label' => 'Inactive'],
                    ]" required />

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.categories.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($category) ? 'Update Category' : 'Create Category' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

