<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductService
{
    public function index(int $perPage = 10, ?string $search = null, ?int $categoryId = null): LengthAwarePaginator
    {
        $query = Product::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Product
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }

    public function find(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }
}

