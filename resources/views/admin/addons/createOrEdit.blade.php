@extends('admin.layouts.app')

@section('title', isset($addon) ? 'Edit Addon' : 'Create Addon')
@section('page-title', isset($addon) ? 'Edit Addon' : 'Create Addon')

@section('admin-content')
    <div>
        <x-ui.page-header :title="isset($addon) ? 'Edit Addon' : 'Create Addon'"
            :description="isset($addon) ? 'Update addon information.' : 'Add a new addon to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ isset($addon) ? route('admin.addons.update', $addon->id) : route('admin.addons.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($addon))
                        @method('PUT')
                    @endif

                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., Extra Cheese"
                        value="{{ old('name', $addon->name ?? '') }}" required />

                    <x-ui.input name="price" type="number" label="Price" step="0.01" min="0"
                        placeholder="e.g., 50.00" value="{{ old('price', $addon->price ?? '0') }}" required />

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.addons.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($addon) ? 'Update Addon' : 'Create Addon' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

