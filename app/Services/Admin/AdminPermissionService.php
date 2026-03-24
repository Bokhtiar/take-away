<?php

namespace App\Services\Admin;

use App\Models\AdminPermission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdminPermissionService
{
    public function index(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = AdminPermission::query();

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

    public function create(array $data): AdminPermission
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        
        return AdminPermission::create($data);
    }

    public function update(AdminPermission $adminPermission, array $data): AdminPermission
    {
        if (isset($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } elseif (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $adminPermission->update($data);
        
        return $adminPermission->fresh();
    }

    public function delete(AdminPermission $adminPermission): bool
    {
        return $adminPermission->delete();
    }

    public function find(int $id): ?AdminPermission
    {
        return AdminPermission::findOrFail($id);
    }
}

