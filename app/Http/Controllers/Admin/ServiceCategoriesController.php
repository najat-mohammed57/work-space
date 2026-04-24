<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceCategoriesController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->withCount('serviceTypes')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.service-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.service-categories.create');
    }

    public function store(StoreServiceCategoryRequest $request): RedirectResponse
    {
        ServiceCategory::query()->create($request->validated());

        return redirect()->route('admin.service-categories.index')->with('status', __('Category created.'));
    }

    public function edit(ServiceCategory $serviceCategory): View
    {
        return view('admin.service-categories.edit', compact('serviceCategory'));
    }

    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->update($request->validated());

        return redirect()->route('admin.service-categories.index')->with('status', __('Category updated.'));
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')->with('status', __('Category removed.'));
    }
}
