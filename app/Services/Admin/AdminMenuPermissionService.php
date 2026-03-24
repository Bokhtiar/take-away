<?php

namespace App\Services\Admin;

use App\Models\AdminMenu;
use App\Models\AdminMenuPermission;
use App\Models\AdminPermission;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminMenuPermissionService
{
    public function index(int $perPage = 10, ?string $search = null, $menuId = null, $permissionId = null): LengthAwarePaginator
    {
        $query = AdminMenuPermission::with(['menu', 'permission']);

        // Apply menu filter if provided
        if ($menuId) {
            $query->where('menu_id', $menuId);
        }

        // Apply permission filter if provided
        if ($permissionId) {
            $query->where('permission_id', $permissionId);
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('menu', function ($menuQuery) use ($search) {
                    $menuQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('permission', function ($permissionQuery) use ($search) {
                    $permissionQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): AdminMenuPermission
    {
        return AdminMenuPermission::create($data);
    }

    public function update(AdminMenuPermission $adminMenuPermission, array $data): AdminMenuPermission
    {
        $adminMenuPermission->update($data);
        
        return $adminMenuPermission->fresh(['menu', 'permission']);
    }

    public function delete(AdminMenuPermission $adminMenuPermission): bool
    {
        return $adminMenuPermission->delete();
    }

    public function find(int $id): ?AdminMenuPermission
    {
        return AdminMenuPermission::with(['menu', 'permission'])->findOrFail($id);
    }

    /**
     * Get all menus (for dropdown).
     */
    public function getMenus()
    {
        return AdminMenu::active()->ordered()->get();
    }

    /**
     * Get all root menus.
     */
    public function getAllMenus()
    {
        return AdminMenu::with('children')
            ->whereNull('parent_id')
            ->ordered()
            ->get();
    }

    /**
     * Get all permissions (for dropdown).
     */
    public function getPermissions()
    {
        return AdminPermission::orderBy('name')->get();
    }

    /**
     * Get menu permissions matrix (menu_id => [permission_id => true/false]).
     */
    public function getMenuPermissionsMatrix(): array
    {
        $matrix = [];
        $menuPermissions = AdminMenuPermission::all();

        foreach ($menuPermissions as $mp) {
            $matrix[$mp->menu_id][$mp->permission_id] = true;
        }

        return $matrix;
    }

    /**
     * Update menu permissions in bulk.
     */
    public function updateBulk(array $permissions): void
    {
        // Delete all existing menu permissions
        AdminMenuPermission::query()->delete();

        // Insert new menu permissions
        foreach ($permissions as $menuId => $permissionIds) {
            foreach ($permissionIds as $permissionId) {
                AdminMenuPermission::create([
                    'menu_id' => $menuId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }
}

