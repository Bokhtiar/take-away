<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleMenuPermissionRequest;
use App\Models\AdminRoleMenuPermission;
use App\Services\Admin\AdminRoleMenuPermissionService;
use Illuminate\Http\Request;

class AdminRoleMenuPermissionController extends Controller
{
    protected $adminRoleMenuPermissionService;

    public function __construct(AdminRoleMenuPermissionService $adminRoleMenuPermissionService)
    {
        $this->adminRoleMenuPermissionService = $adminRoleMenuPermissionService;
    }

    public function index(Request $request)
    {
        $roles = $this->adminRoleMenuPermissionService->getRoles();
        $selectedRoleId = $request->get('role_id');
        $menuPermissionsGrouped = [];
        $existingPermissions = [];

        if ($selectedRoleId) {
            $menuPermissionsGrouped = $this->adminRoleMenuPermissionService->getMenuPermissionsGrouped();
            $existingPermissions = $this->adminRoleMenuPermissionService->getRoleMenuPermissions($selectedRoleId);
        }

        return view('admin.admin-role-menu-permissions.index', compact('roles', 'selectedRoleId', 'menuPermissionsGrouped', 'existingPermissions'));
    }

    public function updateBulk(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:admin_roles,id',
            'permissions' => 'nullable|array',
        ]);

        $this->adminRoleMenuPermissionService->updateBulk(
            $request->input('role_id'),
            $request->input('permissions', [])
        );

        return redirect()->route('admin.admin-role-menu-permissions.index', ['role_id' => $request->input('role_id')])
            ->with('success', 'Role menu permissions updated successfully.');
    }

    public function create()
    {
        $roles = $this->adminRoleMenuPermissionService->getRoles();
        $menuPermissionsGrouped = $this->adminRoleMenuPermissionService->getMenuPermissionsGrouped();
        $selectedRoleId = request('role_id');
        $existingPermissions = [];
        
        if ($selectedRoleId) {
            $existingPermissions = $this->adminRoleMenuPermissionService->getRoleMenuPermissions($selectedRoleId);
        }
        
        return view('admin.admin-role-menu-permissions.createOrEdit', compact('roles', 'menuPermissionsGrouped', 'selectedRoleId', 'existingPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:admin_roles,id',
            'menu_permissions' => 'nullable|array',
            'menu_permissions.*.menu_permission_id' => 'required|exists:admin_menu_permission,id',
            'menu_permissions.*.allow' => 'nullable|boolean',
        ]);

        $roleId = $request->input('role_id');
        $menuPermissions = $request->input('menu_permissions', []);

        // Delete existing mappings for this role
        AdminRoleMenuPermission::where('role_id', $roleId)->delete();

        // Create new mappings - filter out unchecked items
        $data = [];
        foreach ($menuPermissions as $key => $mp) {
            // Only process if menu_permission_id is set (checkbox was checked)
            if (isset($mp['menu_permission_id']) && $mp['menu_permission_id']) {
                $data[] = [
                    'role_id' => $roleId,
                    'menu_permission_id' => $mp['menu_permission_id'],
                    'allow' => isset($mp['allow']) && $mp['allow'] ? true : false,
                ];
            }
        }

        if (!empty($data)) {
            $this->adminRoleMenuPermissionService->createBulk($data);
        }

        return redirect()->route('admin.admin-role-menu-permissions.index')
            ->with('success', 'Role menu permissions assigned successfully.');
    }

    public function show(string $id)
    {
        $adminRoleMenuPermission = $this->adminRoleMenuPermissionService->find($id);
        return view('admin.admin-role-menu-permissions.show', compact('adminRoleMenuPermission'));
    }

    public function edit(string $id)
    {
        $adminRoleMenuPermission = $this->adminRoleMenuPermissionService->find($id);
        $roles = $this->adminRoleMenuPermissionService->getRoles();
        $menuPermissions = $this->adminRoleMenuPermissionService->getMenuPermissions();
        return view('admin.admin-role-menu-permissions.createOrEditSingle', compact('adminRoleMenuPermission', 'roles', 'menuPermissions'));
    }

    public function update(RoleMenuPermissionRequest $request, string $id)
    {
        $adminRoleMenuPermission = $this->adminRoleMenuPermissionService->find($id);

        $validated = $request->validated();

        $this->adminRoleMenuPermissionService->update($adminRoleMenuPermission, $validated);

        return redirect()->route('admin.admin-role-menu-permissions.index')
            ->with('success', 'Role menu permission updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $adminRoleMenuPermission = $this->adminRoleMenuPermissionService->find($id);
            $this->adminRoleMenuPermissionService->delete($adminRoleMenuPermission);

            return redirect()->route('admin.admin-role-menu-permissions.index')
                ->with('success', 'Role menu permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-role-menu-permissions.index')
                ->with('error', 'Failed to delete role menu permission.');
        }
    }

    /**
     * Show form to assign menu permissions to a role (bulk assignment).
     */
    public function assign(Request $request, ?string $roleId = null)
    {
        $roles = $this->adminRoleMenuPermissionService->getRoles();
        $menuPermissionsGrouped = $this->adminRoleMenuPermissionService->getMenuPermissionsGrouped();
        
        $selectedRoleId = $roleId ?? $request->get('role_id');
        $existingPermissions = [];
        
        if ($selectedRoleId) {
            $existingPermissions = $this->adminRoleMenuPermissionService->getRoleMenuPermissions($selectedRoleId);
        }

        return view('admin.admin-role-menu-permissions.createOrEdit', compact('roles', 'menuPermissionsGrouped', 'selectedRoleId', 'existingPermissions'));
    }
}

