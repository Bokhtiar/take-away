<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductAddonRequest;
use App\Models\Addon;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Services\Admin\ProductAddonService;
use Illuminate\Http\Request;

class ProductAddonController extends Controller
{
    public function __construct(private ProductAddonService $productAddonService)
    {
    }

    public function index(Request $request)
    {
        $products = Product::orderBy('name')->get(['id', 'name']);
        $addons = Addon::orderBy('name')->get(['id', 'name', 'price']);

        $selectedProductId = $request->filled('product_id') ? (int) $request->get('product_id') : null;
        $selectedRows = [];

        if ($selectedProductId) {
            $selectedRows = ProductAddon::with('addon:id,name,price')
                ->where('product_id', $selectedProductId)
                ->get()
                ->map(function ($row) {
                    return [
                        'addon_id' => $row->addon_id,
                        'addon_name' => $row->addon?->name,
                        'price' => (float) ($row->addon?->price ?? 0),
                    ];
                })
                ->values()
                ->all();
        }

        return view('admin.product-addons.index', compact(
            'products',
            'addons',
            'selectedProductId',
            'selectedRows'
        ));
    }

    public function store(ProductAddonRequest $request)
    {
        $validated = $request->validated();
        $rows = $validated['rows'] ?? [];

        $this->productAddonService->syncForProduct((int) $validated['product_id'], $rows);

        return redirect()
            ->route('admin.product-addons.index', ['product_id' => $validated['product_id']])
            ->with('success', 'Product addons saved successfully.');
    }
}

