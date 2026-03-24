<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IngredientRequest;
use App\Services\Admin\IngredientService;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');

        $ingredients = $this->ingredientService->index($perPage, $search);

        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.createOrEdit');
    }

    public function store(IngredientRequest $request)
    {
        $this->ingredientService->create($request->validated());

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    public function show(string $id)
    {
        $ingredient = $this->ingredientService->find((int) $id);
        return view('admin.ingredients.show', compact('ingredient'));
    }

    public function edit(string $id)
    {
        $ingredient = $this->ingredientService->find((int) $id);
        return view('admin.ingredients.createOrEdit', compact('ingredient'));
    }

    public function update(IngredientRequest $request, string $id)
    {
        $ingredient = $this->ingredientService->find((int) $id);
        $this->ingredientService->update($ingredient, $request->validated());

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $ingredient = $this->ingredientService->find((int) $id);
            $this->ingredientService->delete($ingredient);

            return redirect()->route('admin.ingredients.index')
                ->with('success', 'Ingredient deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ingredients.index')
                ->with('error', 'Failed to delete ingredient.');
        }
    }
}

