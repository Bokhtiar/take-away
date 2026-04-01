<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChefRequest;
use App\Services\Admin\ChefService;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function __construct(protected ChefService $chefService)
    {
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');

        $chefs = $this->chefService->index($perPage, $search);

        return view('admin.chefs.index', compact('chefs'));
    }

    public function create()
    {
        return view('admin.chefs.createOrEdit');
    }

    public function store(ChefRequest $request)
    {
        $this->chefService->create($request->validated());

        return redirect()
            ->route('admin.chefs.index')
            ->with('success', 'Chef created successfully.');
    }

    public function show(string $id)
    {
        $chef = $this->chefService->find((int) $id);

        return view('admin.chefs.show', compact('chef'));
    }

    public function edit(string $id)
    {
        $chef = $this->chefService->find((int) $id);

        return view('admin.chefs.createOrEdit', compact('chef'));
    }

    public function update(ChefRequest $request, string $id)
    {
        $chef = $this->chefService->find((int) $id);
        $this->chefService->update($chef, $request->validated());

        return redirect()
            ->route('admin.chefs.index')
            ->with('success', 'Chef updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $chef = $this->chefService->find((int) $id);
            $this->chefService->delete($chef);

            return redirect()
                ->route('admin.chefs.index')
                ->with('success', 'Chef deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.chefs.index')
                ->with('error', 'Failed to delete chef.');
        }
    }
}

