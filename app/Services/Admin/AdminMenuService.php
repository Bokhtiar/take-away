<?php

namespace App\Services\Admin;

use App\Models\AdminMenu;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdminMenuService
{
    public function index(int $perPage = 10, ?string $search = null, $parentId = null): LengthAwarePaginator
    {
        $query = AdminMenu::with('parent');

        // Apply parent filter if provided
        if ($parentId !== null) {
            if ($parentId === 'root') {
                // Show only root menus (no parent)
                $query->whereNull('parent_id');
            } else {
                // Show menus with specific parent
                $query->where('parent_id', $parentId);
            }
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhereHas('parent', function ($parentQuery) use ($search) {
                      $parentQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->ordered()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): AdminMenu
    {
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        return AdminMenu::create($data);
    }

    public function update(AdminMenu $adminMenu, array $data): AdminMenu
    {
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $adminMenu->update($data);
        
        return $adminMenu->fresh();
    }

    public function delete(AdminMenu $adminMenu): bool
    {
        return $adminMenu->delete();
    }

    public function find(int $id): ?AdminMenu
    {
        return AdminMenu::with('parent', 'children')->findOrFail($id);
    }

    /**
     * Get all parent menus (for dropdown).
     */
    public function getParentMenus()
    {
        return AdminMenu::parents()->active()->ordered()->get();
    }
}

