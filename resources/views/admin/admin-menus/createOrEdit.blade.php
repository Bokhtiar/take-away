@extends('admin.layouts.app')

@section('title', isset($adminMenu) ? 'Edit Menu' : 'Create Menu')
@section('page-title', isset($adminMenu) ? 'Edit Menu' : 'Create Menu')

@section('admin-content')
    <div class="">
        <x-ui.page-header :title="isset($adminMenu) ? 'Edit Menu' : 'Create Menu'" :description="isset($adminMenu) ? 'Update menu information.' : 'Add a new menu to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form
                    action="{{ isset($adminMenu) ? route('admin.admin-menus.update', $adminMenu->id) : route('admin.admin-menus.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($adminMenu))
                        @method('PUT')
                    @endif

                    <!-- Name -->
                    <x-ui.input name="name" type="text" label="Menu Name" placeholder="e.g., Dashboard"
                        value="{{ old('name', $adminMenu->name ?? '') }}" required />

                    <!-- Slug -->
                    <x-ui.input name="slug" type="text" label="Slug"
                        placeholder="e.g., dashboard (auto-generated if empty)"
                        value="{{ old('slug', $adminMenu->slug ?? '') }}" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Leave empty to auto-generate from name
                    </p>

                    <!-- Icon -->
                    <x-ui.input name="icon" type="text" label="Icon Class" placeholder="e.g., ri-dashboard-line"
                        value="{{ old('icon', $adminMenu->icon ?? '') }}" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Use Remix Icon classes
                        (https://remixicon.com)</p>

                    <!-- URL -->
                    <x-ui.input name="url" type="text" label="URL" placeholder="e.g., /admin/dashboard"
                        value="{{ old('url', $adminMenu->url ?? '') }}" />

                    <!-- Parent Menu -->
                    <x-ui.select name="parent_id" label="Parent Menu" :options="['' => '-- Root Menu --'] + $parentMenus->pluck('name', 'id')->toArray()"
                        selected="{{ old('parent_id', $adminMenu->parent_id ?? '') }}" />

                    <!-- Sort Order -->
                    <x-ui.input name="sort_order" type="number" label="Sort Order" placeholder="0"
                        value="{{ old('sort_order', $adminMenu->sort_order ?? 0) }}" min="0" />

                    <!-- Is Active -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $adminMenu->is_active ?? true) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Inactive menus will not be displayed</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.admin-menus.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($adminMenu) ? 'Update Menu' : 'Create Menu' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
