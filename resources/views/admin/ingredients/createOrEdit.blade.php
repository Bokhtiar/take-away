@extends('admin.layouts.app')

@section('title', isset($ingredient) ? 'Edit Ingredient' : 'Create Ingredient')
@section('page-title', isset($ingredient) ? 'Edit Ingredient' : 'Create Ingredient')

@section('admin-content')
    <div>
        <x-ui.page-header :title="isset($ingredient) ? 'Edit Ingredient' : 'Create Ingredient'"
            :description="isset($ingredient) ? 'Update ingredient information.' : 'Add a new ingredient to the system.'" />

        <div class="my-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ isset($ingredient) ? route('admin.ingredients.update', $ingredient->id) : route('admin.ingredients.store') }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @if (isset($ingredient))
                        @method('PUT')
                    @endif

                    <x-ui.input name="name" type="text" label="Name" placeholder="e.g., Chicken"
                        value="{{ old('name', $ingredient->name ?? '') }}" required />

                    <x-ui.input name="unit" type="text" label="Unit" placeholder="e.g., kg, liter, pcs"
                        value="{{ old('unit', $ingredient->unit ?? '') }}" required />

                    <x-ui.input name="stock_qty" type="number" label="Stock Quantity" step="0.01" min="0"
                        placeholder="e.g., 10.50" value="{{ old('stock_qty', $ingredient->stock_qty ?? '0') }}" required />

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button href="{{ route('admin.ingredients.index') }}" variant="secondary" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" size="md">
                            {{ isset($ingredient) ? 'Update Ingredient' : 'Create Ingredient' }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

