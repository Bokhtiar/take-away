<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\AdminRole;
use App\Services\Admin\AdminRoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRoleController extends Controller
{
    protected $adminRoleService;

    public function __construct(AdminRoleService $adminRoleService)
    {
        $this->adminRoleService = $adminRoleService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $adminRoles = $this->adminRoleService->index($perPage, $search);

        return view('admin.admin-roles.index', compact('adminRoles'));
    }

    public function create()
    {
        return view('admin.admin-roles.createOrEdit');
    }

    public function store(RoleRequest $request)
    {
        $validated = $request->validated();

        $this->adminRoleService->create($validated);

        return redirect()->route('admin.admin-roles.index')
            ->with('success', 'Admin role created successfully.');
    }

    public function show(string $id)
    {
        $adminRole = $this->adminRoleService->find($id);
        return view('admin.admin-roles.show', compact('adminRole'));
    }

    public function edit(string $id)
    {
        $adminRole = $this->adminRoleService->find($id);
        return view('admin.admin-roles.createOrEdit', compact('adminRole'));
    }

    public function update(RoleRequest $request, string $id)
    {
        $adminRole = $this->adminRoleService->find($id);

        $validated = $request->validated();

        $this->adminRoleService->update($adminRole, $validated);

        return redirect()->route('admin.admin-roles.index')
            ->with('success', 'Admin role updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $adminRole = $this->adminRoleService->find($id);
            $this->adminRoleService->delete($adminRole);

            return redirect()->route('admin.admin-roles.index')
                ->with('success', 'Admin role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-roles.index')
                ->with('error', 'Failed to delete admin role.');
        }
    }
}
