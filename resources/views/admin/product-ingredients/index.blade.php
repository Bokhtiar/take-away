@extends('admin.layouts.app')

@section('title', 'Product Ingredients')
@section('page-title', 'Product Ingredients')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Product Ingredients" description="Assign multiple ingredients to a selected product on one page." />

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <form method="GET" action="{{ route('admin.product-ingredients.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <x-ui.select name="product_id" label="Select Product" :value="$selectedProductId ?? ''" :options="$products->map(fn ($product) => ['value' => $product->id, 'label' => $product->name])->values()->all()" required />
                <div>
                    <x-ui.button type="submit" variant="primary" size="md">Load Ingredients</x-ui.button>
                </div>
            </form>
        </div>

        @if ($selectedProductId)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.product-ingredients.store') }}" id="mappingForm" class="space-y-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $selectedProductId }}">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-ui.input id="ingredientSearch" name="ingredient_search" type="text" label="Search Ingredient" placeholder="Type ingredient name..." />

                        <div>
                            <label for="ingredientPicker" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ingredients</label>
                            <select id="ingredientPicker"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select ingredient</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-name="{{ strtolower($ingredient->name) }}" data-unit="{{ $ingredient->unit }}" data-label="{{ $ingredient->name }}">
                                        {{ $ingredient->name }} ({{ $ingredient->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-ui.button type="button" id="addIngredientBtn" variant="secondary" size="md">Add Ingredient</x-ui.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="w-full text-sm" id="ingredientTable">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Ingredient</th>
                                    <th class="px-4 py-3 text-left font-semibold">Unit</th>
                                    <th class="px-4 py-3 text-left font-semibold">Qty</th>
                                    <th class="px-4 py-3 text-left font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody id="ingredientRows" class="divide-y divide-gray-200 dark:divide-gray-700">
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <x-ui.button type="submit" variant="primary" size="md">Save Product Ingredients</x-ui.button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('admin-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedRows = @json($selectedRows ?? []);
        const ingredientPicker = document.getElementById('ingredientPicker');
        const ingredientSearch = document.getElementById('ingredientSearch');
        const addIngredientBtn = document.getElementById('addIngredientBtn');
        const ingredientRows = document.getElementById('ingredientRows');

        if (!ingredientPicker || !addIngredientBtn || !ingredientRows) {
            return;
        }

        function renderRow(ingredientId, ingredientName, unit, qty = '') {
            const rowId = `row-${ingredientId}`;
            if (document.getElementById(rowId)) return;

            const index = ingredientRows.querySelectorAll('tr').length;
            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.innerHTML = `
                <td class="px-4 py-3 text-gray-900 dark:text-white">
                    ${ingredientName}
                    <input type="hidden" name="rows[${index}][ingredient_id]" value="${ingredientId}">
                </td>
                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">${unit}</td>
                <td class="px-4 py-3">
                    <input type="number" step="0.01" min="0.01" name="rows[${index}][qty]" value="${qty}"
                        class="w-36 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                </td>
                <td class="px-4 py-3">
                    <button type="button" class="text-red-600 hover:text-red-700" onclick="this.closest('tr').remove(); reindexRows();">
                        Remove
                    </button>
                </td>
            `;
            ingredientRows.appendChild(tr);
        }

        window.reindexRows = function () {
            const rows = ingredientRows.querySelectorAll('tr');
            rows.forEach((row, idx) => {
                const ingredientInput = row.querySelector('input[type="hidden"]');
                const qtyInput = row.querySelector('input[type="number"]');
                ingredientInput.name = `rows[${idx}][ingredient_id]`;
                qtyInput.name = `rows[${idx}][qty]`;
            });
        };

        addIngredientBtn.addEventListener('click', function () {
            const option = ingredientPicker.options[ingredientPicker.selectedIndex];
            if (!option || !option.value) return;

            renderRow(option.value, option.dataset.label, option.dataset.unit, '');
            reindexRows();
        });

        ingredientSearch?.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            Array.from(ingredientPicker.options).forEach((option, idx) => {
                if (idx === 0) return;
                option.hidden = term && !option.dataset.name.includes(term);
            });
        });

        selectedRows.forEach((row) => {
            renderRow(row.ingredient_id, row.ingredient_name, row.unit, row.qty);
        });
        reindexRows();
    });
</script>
@endpush

