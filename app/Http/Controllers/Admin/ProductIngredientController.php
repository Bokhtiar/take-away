<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductIngredientRequest;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Services\Admin\ProductIngredientService;
use Illuminate\Http\Request;

class ProductIngredientController extends Controller
{
    public function __construct(private ProductIngredientService $productIngredientService)
    {
    }

    public function index(Request $request)
    {
        $products = Product::orderBy('name')->get(['id', 'name']);
        $ingredients = Ingredient::orderBy('name')->get(['id', 'name', 'unit']);

        $selectedProductId = $request->filled('product_id') ? (int) $request->get('product_id') : null;
        $selectedRows = [];

        if ($selectedProductId) {
            $selectedRows = ProductIngredient::with('ingredient:id,name,unit')
                ->where('product_id', $selectedProductId)
                ->get()
                ->map(function ($row) {
                    return [
                        'ingredient_id' => $row->ingredient_id,
                        'ingredient_name' => $row->ingredient?->name,
                        'unit' => $row->ingredient?->unit,
                        'qty' => (float) $row->qty,
                    ];
                })
                ->values()
                ->all();
        }

        return view('admin.product-ingredients.index', compact(
            'products',
            'ingredients',
            'selectedProductId',
            'selectedRows'
        ));
    }

    public function store(ProductIngredientRequest $request)
    {
        $validated = $request->validated();
        $rows = $validated['rows'] ?? [];

        $this->productIngredientService->syncForProduct((int) $validated['product_id'], $rows);

        return redirect()
            ->route('admin.product-ingredients.index', ['product_id' => $validated['product_id']])
            ->with('success', 'Product ingredients saved successfully.');
    }
}

