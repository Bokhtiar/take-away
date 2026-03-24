<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $roleId = $request->get('role_id');
        
        $admins = $this->adminService->index($perPage, $search, $roleId);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = AdminRole::orderBy('name')->get();
        return view('admin.admins.createOrEdit', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $validated = $request->validated();

        $this->adminService->create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function show(string $id)
    {
        $admin = $this->adminService->find($id);
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(string $id)
    {
        $admin = $this->adminService->find($id);
        $roles = AdminRole::orderBy('name')->get();
        return view('admin.admins.createOrEdit', compact('admin', 'roles'));
    }

    public function update(AdminRequest $request, string $id)
    {
        $admin = $this->adminService->find($id);

        $validated = $request->validated();

        $this->adminService->update($admin, $validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $admin = $this->adminService->find($id);
            $this->adminService->delete($admin);

            return redirect()->route('admin.admins.index')
                ->with('success', 'Admin deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Failed to delete admin.');
        }
    }
}

