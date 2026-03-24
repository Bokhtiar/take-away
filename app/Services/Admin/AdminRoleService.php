<?php

namespace App\Services\Admin;

use App\Models\AdminRole;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdminRoleService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = AdminRole::query();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): AdminRole
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        
        return AdminRole::create($data);
    }

    public function update(AdminRole $adminRole, array $data): AdminRole
    {
        if (isset($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } elseif (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $adminRole->update($data);
        
        return $adminRole->fresh();
    }

    public function delete(AdminRole $adminRole): bool
    {
        return $adminRole->delete();
    }

    public function find(int $id): ?AdminRole
    {
        return AdminRole::findOrFail($id);
    }
}

