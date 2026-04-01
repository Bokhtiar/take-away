<?php

namespace App\Services\Admin;

use App\Models\Chef;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class ChefService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Chef::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Chef
    {
        $data['password'] = Hash::make((string) $data['password']);
        return Chef::create($data);
    }

    public function update(Chef $chef, array $data): Chef
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make((string) $data['password']);
        } else {
            unset($data['password']);
        }

        $chef->update($data);
        return $chef->fresh();
    }

    public function delete(Chef $chef): bool
    {
        return (bool) $chef->delete();
    }

    public function find(int $id): Chef
    {
        return Chef::findOrFail($id);
    }
}

