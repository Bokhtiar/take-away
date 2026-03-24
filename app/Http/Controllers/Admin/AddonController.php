<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddonRequest;
use App\Services\Admin\AddonService;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function __construct(private AddonService $addonService)
    {
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search');

        $addons = $this->addonService->index($perPage, $search);
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.createOrEdit');
    }

    public function store(AddonRequest $request)
    {
        $this->addonService->create($request->validated());
        return redirect()->route('admin.addons.index')->with('success', 'Addon created successfully.');
    }

    public function show(string $id)
    {
        $addon = $this->addonService->find((int) $id);
        return view('admin.addons.show', compact('addon'));
    }

    public function edit(string $id)
    {
        $addon = $this->addonService->find((int) $id);
        return view('admin.addons.createOrEdit', compact('addon'));
    }

    public function update(AddonRequest $request, string $id)
    {
        $addon = $this->addonService->find((int) $id);
        $this->addonService->update($addon, $request->validated());
        return redirect()->route('admin.addons.index')->with('success', 'Addon updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $addon = $this->addonService->find((int) $id);
            $this->addonService->delete($addon);
            return redirect()->route('admin.addons.index')->with('success', 'Addon deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.addons.index')->with('error', 'Failed to delete addon.');
        }
    }
}

