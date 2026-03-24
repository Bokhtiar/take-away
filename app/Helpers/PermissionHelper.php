<?php

if (!function_exists('can')) {
    function can(string $permission): bool
    {
        if (!session('admin_id')) {
            return false;
        }

        if (strpos($permission, '.') === false) {
            return false;
        }

        [$menu, $action] = explode('.', $permission, 2);
        $permissions = session('admin_permissions', []);

        return isset($permissions[$menu]) && in_array($action, $permissions[$menu]);
    }
}

