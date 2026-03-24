<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuPermissionRequest;
use App\Models\AdminMenuPermission;
use App\Services\Admin\AdminMenuPermissionService;
use Illuminate\Http\Request;

class AdminMenuPermissionController extends Controller
{
    protected $adminMenuPermissionService;

    public function __construct(AdminMenuPermissionService $adminMenuPermissionService)
    {
        $this->adminMenuPermissionService = $adminMenuPermissionService;
    }

    public function index(Request $request)
    {
        $menus = $this->adminMenuPermissionService->getAllMenus();
        $permissions = $this->adminMenuPermissionService->getPermissions();
        $menuPermissions = $this->adminMenuPermissionService->getMenuPermissionsMatrix();

        return view('admin.admin-menu-permissions.index', compact('menus', 'permissions', 'menuPermissions'));
    }

    public function updateBulk(Request $request)
    {
        $this->adminMenuPermissionService->updateBulk($request->input('permissions', []));

        return redirect()->route('admin.admin-menu-permissions.index')
            ->with('success', 'Menu permissions updated successfully.');
    }

    public function create()
    {
        $menus = $this->adminMenuPermissionService->getMenus();
        $permissions = $this->adminMenuPermissionService->getPermissions();
        return view('admin.admin-menu-permissions.createOrEdit', compact('menus', 'permissions'));
    }

    public function store(MenuPermissionRequest $request)
    {
        $validated = $request->validated();

        $this->adminMenuPermissionService->create($validated);

        return redirect()->route('admin.admin-menu-permissions.index')
            ->with('success', 'Menu permission mapping created successfully.');
    }

    public function show(string $id)
    {
        $adminMenuPermission = $this->adminMenuPermissionService->find($id);
        return view('admin.admin-menu-permissions.show', compact('adminMenuPermission'));
    }

    public function edit(string $id)
    {
        $adminMenuPermission = $this->adminMenuPermissionService->find($id);
        $menus = $this->adminMenuPermissionService->getMenus();
        $permissions = $this->adminMenuPermissionService->getPermissions();
        return view('admin.admin-menu-permissions.createOrEdit', compact('adminMenuPermission', 'menus', 'permissions'));
    }

    public function update(MenuPermissionRequest $request, string $id)
    {
        $adminMenuPermission = $this->adminMenuPermissionService->find($id);

        $validated = $request->validated();

        $this->adminMenuPermissionService->update($adminMenuPermission, $validated);

        return redirect()->route('admin.admin-menu-permissions.index')
            ->with('success', 'Menu permission mapping updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $adminMenuPermission = $this->adminMenuPermissionService->find($id);
            $this->adminMenuPermissionService->delete($adminMenuPermission);

            return redirect()->route('admin.admin-menu-permissions.index')
                ->with('success', 'Menu permission mapping deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-menu-permissions.index')
                ->with('error', 'Failed to delete menu permission mapping.');
        }
    }
}

