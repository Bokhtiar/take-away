<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\AdminMenu;
use App\Services\Admin\AdminMenuService;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    protected $adminMenuService;

    public function __construct(AdminMenuService $adminMenuService)
    {
        $this->adminMenuService = $adminMenuService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $parentId = $request->get('parent_id');
        
        $adminMenus = $this->adminMenuService->index($perPage, $search, $parentId);

        return view('admin.admin-menus.index', compact('adminMenus'));
    }

    public function create()
    {
        $parentMenus = $this->adminMenuService->getParentMenus();
        return view('admin.admin-menus.createOrEdit', compact('parentMenus'));
    }

    public function store(MenuRequest $request)
    {
        $validated = $request->validated();

        $this->adminMenuService->create($validated);

        return redirect()->route('admin.admin-menus.index')
            ->with('success', 'Menu created successfully.');
    }

    public function show(string $id)
    {
        $adminMenu = $this->adminMenuService->find($id);
        return view('admin.admin-menus.show', compact('adminMenu'));
    }

    public function edit(string $id)
    {
        $adminMenu = $this->adminMenuService->find($id);
        $parentMenus = $this->adminMenuService->getParentMenus();
        return view('admin.admin-menus.createOrEdit', compact('adminMenu', 'parentMenus'));
    }

    public function update(MenuRequest $request, string $id)
    {
        $adminMenu = $this->adminMenuService->find($id);

        $validated = $request->validated();

        $this->adminMenuService->update($adminMenu, $validated);

        return redirect()->route('admin.admin-menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $adminMenu = $this->adminMenuService->find($id);
            $this->adminMenuService->delete($adminMenu);

            return redirect()->route('admin.admin-menus.index')
                ->with('success', 'Menu deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-menus.index')
                ->with('error', 'Failed to delete menu.');
        }
    }
}

