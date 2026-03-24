@extends('admin.layouts.app')

@section('title', 'Product Addons')
@section('page-title', 'Product Addons')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Product Addons" description="Assign multiple addons to a selected product on one page." />

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <form method="GET" action="{{ route('admin.product-addons.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <x-ui.select name="product_id" label="Select Product" :value="$selectedProductId ?? ''" :options="$products->map(fn ($product) => ['value' => $product->id, 'label' => $product->name])->values()->all()" required />
                <div>
                    <x-ui.button type="submit" variant="primary" size="md">Load Addons</x-ui.button>
                </div>
            </form>
        </div>

        @if ($selectedProductId)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.product-addons.store') }}" id="mappingForm" class="space-y-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $selectedProductId }}">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-ui.input id="addonSearch" name="addon_search" type="text" label="Search Addon" placeholder="Type addon name..." />

                        <div>
                            <label for="addonPicker" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Addons</label>
                            <select id="addonPicker"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select addon</option>
                                @foreach ($addons as $addon)
                                    <option value="{{ $addon->id }}" data-name="{{ strtolower($addon->name) }}" data-price="{{ $addon->price }}" data-label="{{ $addon->name }}">
                                        {{ $addon->name }} ({{ number_format((float) $addon->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-ui.button type="button" id="addAddonBtn" variant="secondary" size="md">Add Addon</x-ui.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Addon</th>
                                    <th class="px-4 py-3 text-left font-semibold">Price</th>
                                    <th class="px-4 py-3 text-left font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody id="addonRows" class="divide-y divide-gray-200 dark:divide-gray-700"></tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <x-ui.button type="submit" variant="primary" size="md">Save Product Addons</x-ui.button>
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
        const addonPicker = document.getElementById('addonPicker');
        const addonSearch = document.getElementById('addonSearch');
        const addAddonBtn = document.getElementById('addAddonBtn');
        const addonRows = document.getElementById('addonRows');

        if (!addonPicker || !addAddonBtn || !addonRows) {
            return;
        }

        function renderRow(addonId, addonName, price = '') {
            const rowId = `row-${addonId}`;
            if (document.getElementById(rowId)) return;

            const index = addonRows.querySelectorAll('tr').length;
            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.innerHTML = `
                <td class="px-4 py-3 text-gray-900 dark:text-white">
                    ${addonName}
                    <input type="hidden" name="rows[${index}][addon_id]" value="${addonId}">
                </td>
                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">${Number(price).toFixed(2)}</td>
                <td class="px-4 py-3">
                    <button type="button" class="text-red-600 hover:text-red-700" onclick="this.closest('tr').remove(); reindexAddonRows();">
                        Remove
                    </button>
                </td>
            `;
            addonRows.appendChild(tr);
        }

        window.reindexAddonRows = function () {
            const rows = addonRows.querySelectorAll('tr');
            rows.forEach((row, idx) => {
                const addonInput = row.querySelector('input[type="hidden"]');
                addonInput.name = `rows[${idx}][addon_id]`;
            });
        };

        addAddonBtn.addEventListener('click', function () {
            const option = addonPicker.options[addonPicker.selectedIndex];
            if (!option || !option.value) return;

            renderRow(option.value, option.dataset.label, option.dataset.price);
            reindexAddonRows();
        });

        addonSearch?.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            Array.from(addonPicker.options).forEach((option, idx) => {
                if (idx === 0) return;
                option.hidden = term && !option.dataset.name.includes(term);
            });
        });

        selectedRows.forEach((row) => {
            renderRow(row.addon_id, row.addon_name, row.price);
        });
        reindexAddonRows();
    });
</script>
@endpush

