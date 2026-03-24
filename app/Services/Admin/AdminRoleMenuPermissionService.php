<?php

namespace App\Services\Admin;

use App\Models\AdminRole;
use App\Models\AdminRoleMenuPermission;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRoleMenuPermissionService
{
    public function index(int $perPage = 10, ?string $search = null, $roleId = null): LengthAwarePaginator
    {
        $query = AdminRoleMenuPermission::with(['role', 'menuPermission.menu', 'menuPermission.permission']);

        // Apply role filter if provided
        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('role', function ($roleQuery) use ($search) {
                    $roleQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('menuPermission.menu', function ($menuQuery) use ($search) {
                    $menuQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('menuPermission.permission', function ($permissionQuery) use ($search) {
                    $permissionQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): AdminRoleMenuPermission
    {
        return AdminRoleMenuPermission::create($data);
    }

    public function createBulk(array $data): array
    {
        $created = [];
        foreach ($data as $item) {
            // Check if already exists
            $exists = AdminRoleMenuPermission::where('role_id', $item['role_id'])
                ->where('menu_permission_id', $item['menu_permission_id'])
                ->exists();

            if (!$exists) {
                $created[] = AdminRoleMenuPermission::create($item);
            }
        }
        return $created;
    }

    public function update(AdminRoleMenuPermission $adminRoleMenuPermission, array $data): AdminRoleMenuPermission
    {
        $adminRoleMenuPermission->update($data);
        
        return $adminRoleMenuPermission->fresh(['role', 'menuPermission.menu', 'menuPermission.permission']);
    }

    public function delete(AdminRoleMenuPermission $adminRoleMenuPermission): bool
    {
        return $adminRoleMenuPermission->delete();
    }

    public function find(int $id): ?AdminRoleMenuPermission
    {
        return AdminRoleMenuPermission::with(['role', 'menuPermission.menu', 'menuPermission.permission'])->findOrFail($id);
    }

    /**
     * Get all roles (for dropdown).
     */
    public function getRoles()
    {
        return AdminRole::orderBy('name')->get();
    }

    /**
     * Get all menu permissions (for dropdown/table).
     */
    public function getMenuPermissions()
    {
        return \App\Models\AdminMenuPermission::with(['menu', 'permission'])
            ->orderBy('menu_id')
            ->orderBy('permission_id')
            ->get();
    }

    /**
     * Get menu permissions grouped by menu with parent-child hierarchy.
     */
    public function getMenuPermissionsGrouped()
    {
        $allMenus = \App\Models\AdminMenu::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $menuPermissions = \App\Models\AdminMenuPermission::with(['menu', 'permission'])
            ->get()
            ->groupBy('menu_id');
        
        // Build hierarchical structure
        $hierarchy = [];
        
        foreach ($allMenus as $menu) {
            if ($menu->parent_id === null) {
                // Root menu
                $rootData = [
                    'menu' => $menu,
                    'permissions' => $menuPermissions->get($menu->id, collect()),
                    'children' => []
                ];
                
                // Find children
                foreach ($allMenus as $childMenu) {
                    if ($childMenu->parent_id === $menu->id) {
                        $rootData['children'][] = [
                            'menu' => $childMenu,
                            'permissions' => $menuPermissions->get($childMenu->id, collect())
                        ];
                    }
                }
                
                $hierarchy[] = $rootData;
            }
        }
        
        return $hierarchy;
    }

    /**
     * Get existing role-menu-permissions for a role.
     */
    public function getRoleMenuPermissions($roleId)
    {
        return AdminRoleMenuPermission::where('role_id', $roleId)
            ->pluck('allow', 'menu_permission_id')
            ->toArray();
    }

    /**
     * Update role menu permissions in bulk (simplified checkbox-only format).
     */
    public function updateBulk($roleId, array $permissions): void
    {
        // Delete all existing permissions for this role
        AdminRoleMenuPermission::where('role_id', $roleId)->delete();

        // Insert new permissions
        $data = [];
        foreach ($permissions as $menuPermissionId => $value) {
            // Checkbox checked = value is '1' = allow
            if ($value == '1') {
                $data[] = [
                    'role_id' => $roleId,
                    'menu_permission_id' => $menuPermissionId,
                    'allow' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($data)) {
            AdminRoleMenuPermission::insert($data);
        }
    }
}

