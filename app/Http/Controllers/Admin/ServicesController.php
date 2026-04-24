<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Feature;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServicesController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->with(['serviceType.serviceCategory'])
            ->withCount('features')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        $serviceTypes = ServiceType::query()->with('serviceCategory')->orderBy('name')->get();
        $features = Feature::query()->orderBy('name')->get();

        return view('admin.services.create', compact('serviceTypes', 'features'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        if (! $request->has('feature_ids')) {
            $request->merge(['feature_ids' => []]);
        }

        $data = $request->validated();
        $featureIds = $data['feature_ids'] ?? [];
        unset($data['feature_ids']);

        $data['is_active'] = $request->boolean('is_active');

        $service = Service::query()->create($data);
        $service->features()->sync($featureIds);

        return redirect()->route('admin.services.index')->with('status', __('Service created.'));
    }

    public function edit(Service $service): View
    {
        $service->load('features');
        $serviceTypes = ServiceType::query()->with('serviceCategory')->orderBy('name')->get();
        $features = Feature::query()->orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'serviceTypes', 'features'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        if (! $request->has('feature_ids')) {
            $request->merge(['feature_ids' => []]);
        }

        $data = $request->validated();

        if (array_key_exists('feature_ids', $data)) {
            $service->features()->sync($data['feature_ids'] ?? []);
            unset($data['feature_ids']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', __('Service updated.'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', __('Service removed.'));
    }
}
