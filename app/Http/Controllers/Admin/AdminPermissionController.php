<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\AdminPermission;
use App\Services\Admin\AdminPermissionService;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    protected $adminPermissionService;

    public function __construct(AdminPermissionService $adminPermissionService)
    {
        $this->adminPermissionService = $adminPermissionService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $adminPermissions = $this->adminPermissionService->index($perPage, $search);

        return view('admin.admin-permissions.index', compact('adminPermissions'));
    }

    public function create()
    {
        return view('admin.admin-permissions.createOrEdit');
    }

    public function store(PermissionRequest $request)
    {
        $validated = $request->validated();

        $this->adminPermissionService->create($validated);

        return redirect()->route('admin.admin-permissions.index')
            ->with('success', 'Admin permission created successfully.');
    }

    public function show(string $id)
    {
        $adminPermission = $this->adminPermissionService->find($id);
        return view('admin.admin-permissions.show', compact('adminPermission'));
    }

    public function edit(string $id)
    {
        $adminPermission = $this->adminPermissionService->find($id);
        return view('admin.admin-permissions.createOrEdit', compact('adminPermission'));
    }

    public function update(PermissionRequest $request, string $id)
    {
        $adminPermission = $this->adminPermissionService->find($id);

        $validated = $request->validated();

        $this->adminPermissionService->update($adminPermission, $validated);

        return redirect()->route('admin.admin-permissions.index')
            ->with('success', 'Admin permission updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $adminPermission = $this->adminPermissionService->find($id);
            $this->adminPermissionService->delete($adminPermission);

            return redirect()->route('admin.admin-permissions.index')
                ->with('success', 'Admin permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-permissions.index')
                ->with('error', 'Failed to delete admin permission.');
        }
    }
}

