<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $categories = $this->categoryService->index($perPage, $search);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.createOrEdit');
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $this->categoryService->create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        $category = $this->categoryService->find((int) $id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = $this->categoryService->find((int) $id);
        return view('admin.categories.createOrEdit', compact('category'));
    }

    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->categoryService->find((int) $id);
        $validated = $request->validated();

        $this->categoryService->update($category, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $category = $this->categoryService->find((int) $id);
            $this->categoryService->delete($category);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to delete category.');
        }
    }
}

