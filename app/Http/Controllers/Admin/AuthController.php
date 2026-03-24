<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\PermissionService;

class AuthController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $admin = $request->authenticate();

        // Store admin info in session
        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_role_id' => $admin->role_id,
            'admin_role_name' => $admin->role?->name,
        ]);

        // Load permissions (slug-based for backend Gate checking)
        $permissions = $this->permissionService->loadAdminPermissions($admin);
        session(['admin_permissions' => $permissions]);

        // Load full menu structure (for frontend rendering)
        $menuStructure = $this->permissionService->loadMenuStructure($admin);
        session(['admin_menu_structure' => $menuStructure]);

        return redirect()->route('admin.dashboard');
    }

    public function register()
    {
        // TODO: Implement registration
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_role_id', 'admin_role_name', 'admin_permissions', 'admin_menu_structure']);
        return redirect()->route('admin.login');
    }

    public function refresh()
    {
        // TODO: Implement token refresh
    }

    public function me()
    {
        // TODO: Implement get current user
    }
}

