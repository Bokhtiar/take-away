<?php

namespace App\Services\Admin;

use App\Models\Addon;
use Illuminate\Pagination\LengthAwarePaginator;

class AddonService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Addon::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Addon
    {
        return Addon::create($data);
    }

    public function update(Addon $addon, array $data): Addon
    {
        $addon->update($data);
        return $addon->fresh();
    }

    public function delete(Addon $addon): bool
    {
        return (bool) $addon->delete();
    }

    public function find(int $id): Addon
    {
        return Addon::findOrFail($id);
    }
}

