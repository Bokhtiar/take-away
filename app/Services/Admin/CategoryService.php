<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Category::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }

    public function find(int $id): Category
    {
        return Category::findOrFail($id);
    }
}

