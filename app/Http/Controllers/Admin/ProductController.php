<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');
        $categoryId = $request->filled('category_id') ? (int) $request->get('category_id') : null;

        $products = $this->productService->index($perPage, $search, $categoryId);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.createOrEdit', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $this->productService->create($request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        $product = $this->productService->find((int) $id);
        return view('admin.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = $this->productService->find((int) $id);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.createOrEdit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, string $id)
    {
        $product = $this->productService->find((int) $id);
        $this->productService->update($product, $request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $product = $this->productService->find((int) $id);
            $this->productService->delete($product);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Failed to delete product.');
        }
    }
}

