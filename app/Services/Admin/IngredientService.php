<?php

namespace App\Services\Admin;

use App\Models\Ingredient;
use Illuminate\Pagination\LengthAwarePaginator;

class IngredientService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Ingredient::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Ingredient
    {
        return Ingredient::create($data);
    }

    public function update(Ingredient $ingredient, array $data): Ingredient
    {
        $ingredient->update($data);
        return $ingredient->fresh();
    }

    public function delete(Ingredient $ingredient): bool
    {
        return (bool) $ingredient->delete();
    }

    public function find(int $id): Ingredient
    {
        return Ingredient::findOrFail($id);
    }
}

