@extends('admin.layouts.app')

@section('title', isset($adminPermission) ? 'Edit Admin Permission' : 'Create Admin Permission')
@section('page-title', isset($adminPermission) ? 'Edit Admin Permission' : 'Create Admin Permission')

@section('admin-content')
    <div class="">
        <x-ui.page-header :title="isset($adminPermission) ? 'Edit Admin Permission' : 'Create Admin Permission'" :description="isset($adminPermission) ? 'Update admin permission information.' : 'Add a new admin permission to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form
                    action="{{ isset($adminPermission) ? route('admin.admin-permissions.update', $adminPermission->id) : route('admin.admin-permissions.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($adminPermission))
                        @method('PUT')
                    @endif

                    <!-- Name -->
                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., View, Create, Edit, Delete"
                        value="{{ old('name', $adminPermission->name ?? '') }}" required />

                    <!-- Slug -->
                    <x-ui.input name="slug" type="text" label="Slug"
                        placeholder="e.g., view, create, edit, delete (auto-generated if empty)"
                        value="{{ old('slug', $adminPermission->slug ?? '') }}" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Leave empty to auto-generate from name
                    </p>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter permission description...">{{ old('description', $adminPermission->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.admin-permissions.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($adminPermission) ? 'Update Permission' : 'Create Permission' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

