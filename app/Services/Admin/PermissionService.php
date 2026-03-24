<?php

namespace App\Services\Admin;

use App\Models\Admin;

class PermissionService
{
    /**
     * Load and structure admin permissions
     * Returns: ['menu_slug' => ['permission_slug1', 'permission_slug2']]
     */
    public function loadAdminPermissions(Admin $admin): array
    {
        $permissions = [];

        if (!$admin->role) {
            return $permissions;
        }

        $admin->load([
            'role.roleMenuPermissions.menuPermission.menu',
            'role.roleMenuPermissions.menuPermission.permission'
        ]);

        foreach ($admin->role->roleMenuPermissions as $roleMenuPerm) {
            if (!$roleMenuPerm->allow) {
                continue;
            }

            $menuPermission = $roleMenuPerm->menuPermission;
            if (!$menuPermission || !$menuPermission->menu || !$menuPermission->permission) {
                continue;
            }

            $menuSlug = $menuPermission->menu->slug;
            $permissionSlug = $menuPermission->permission->slug;

            if (!isset($permissions[$menuSlug])) {
                $permissions[$menuSlug] = [];
            }

            $permissions[$menuSlug][] = $permissionSlug;
        }

        return $permissions;
    }

    /**
     * Load full menu structure with permissions for UI rendering
     */
    public function loadMenuStructure(Admin $admin): array
    {
        $menusById = [];

        if (!$admin->role) {
            return [];
        }

        $admin->load([
            'role.roleMenuPermissions.menuPermission.menu',
            'role.roleMenuPermissions.menuPermission.permission'
        ]);

        foreach ($admin->role->roleMenuPermissions as $roleMenuPerm) {
            if (!$roleMenuPerm->allow) {
                continue;
            }

            $menuPermission = $roleMenuPerm->menuPermission;
            if (!$menuPermission || !$menuPermission->menu || !$menuPermission->permission) {
                continue;
            }

            $menu = $menuPermission->menu;
            $menuId = $menu->id;
            $permissionSlug = $menuPermission->permission->slug;

            if (!isset($menusById[$menuId])) {
                $menusById[$menuId] = [
                    'menu_id' => $menuId,
                    'menu_name' => $menu->name,
                    'menu_slug' => $menu->slug,
                    'menu_url' => $menu->url,
                    'menu_icon' => $menu->icon,
                    'parent_id' => $menu->parent_id,
                    'sort_order' => $menu->sort_order,
                    'is_active' => $menu->is_active,
                    'permissions' => [],
                    'children' => []
                ];
            }

            $menusById[$menuId]['permissions'][$permissionSlug] = true;
        }

        // Build nested structure
        $nestedMenus = [];

        foreach ($menusById as $menu) {
            if ($menu['parent_id'] === null) {
                $nestedMenus[$menu['menu_id']] = $menu;
            } else {
                $parentId = $menu['parent_id'];
                if (isset($menusById[$parentId])) {
                    $menusById[$parentId]['children'][] = $menu;
                }
            }
        }

        // Update root menus with children
        foreach ($nestedMenus as $menuId => $rootMenu) {
            if (isset($menusById[$menuId]['children'])) {
                $nestedMenus[$menuId]['children'] = $menusById[$menuId]['children'];
            }
        }

        return $nestedMenus;
    }

    /**
     * Check if admin has permission
     */
    public function hasPermission(string $menuSlug, string $permissionSlug): bool
    {
        $permissions = session('admin_permissions', []);

        if (!isset($permissions[$menuSlug])) {
            return false;
        }

        return in_array($permissionSlug, $permissions[$menuSlug]);
    }

    /**
     * Get all admin permissions from session
     */
    public function getPermissions(): array
    {
        return session('admin_permissions', []);
    }
}

