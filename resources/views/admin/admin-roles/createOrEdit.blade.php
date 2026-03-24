@extends('admin.layouts.app')

@section('title', isset($adminRole) ? 'Edit Admin Role' : 'Create Admin Role')
@section('page-title', isset($adminRole) ? 'Edit Admin Role' : 'Create Admin Role')

@section('admin-content')
    <div class="">
        <x-ui.page-header :title="isset($adminRole) ? 'Edit Admin Role' : 'Create Admin Role'" :description="isset($adminRole) ? 'Update admin role information.' : 'Add a new admin role to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form
                    action="{{ isset($adminRole) ? route('admin.admin-roles.update', $adminRole->id) : route('admin.admin-roles.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($adminRole))
                        @method('PUT')
                    @endif

                    <!-- Name -->
                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., Super Admin"
                        value="{{ old('name', $adminRole->name ?? '') }}" required />

                    <!-- Slug -->
                    <x-ui.input name="slug" type="text" label="Slug"
                        placeholder="e.g., super_admin (auto-generated if empty)"
                        value="{{ old('slug', $adminRole->slug ?? '') }}" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Leave empty to auto-generate from name
                    </p>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter role description...">{{ old('description', $adminRole->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.admin-roles.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($adminRole) ? 'Update Role' : 'Create Role' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
