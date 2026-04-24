<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Http\Requests\UpdateServiceTypeRequest;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceTypesController extends Controller
{
    public function index(): View
    {
        $serviceTypes = ServiceType::query()
            ->with('serviceCategory')
            ->withCount('services')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.service-types.index', compact('serviceTypes'));
    }

    public function create(): View
    {
        $categories = ServiceCategory::query()->orderBy('name')->get();

        return view('admin.service-types.create', compact('categories'));
    }

    public function store(StoreServiceTypeRequest $request): RedirectResponse
    {
        ServiceType::query()->create($request->validated());

        return redirect()->route('admin.service-types.index')->with('status', __('Service type created.'));
    }

    public function edit(ServiceType $serviceType): View
    {
        $categories = ServiceCategory::query()->orderBy('name')->get();

        return view('admin.service-types.edit', compact('serviceType', 'categories'));
    }

    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType): RedirectResponse
    {
        $serviceType->update($request->validated());

        return redirect()->route('admin.service-types.index')->with('status', __('Service type updated.'));
    }

    public function destroy(ServiceType $serviceType): RedirectResponse
    {
        $serviceType->delete();

        return redirect()->route('admin.service-types.index')->with('status', __('Service type removed.'));
    }
}
