<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FeatureApplicableTo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FeaturesController extends Controller
{
    public function index(): View
    {
        $features = Feature::query()
            ->withCount('services')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.features.index', compact('features'));
    }

    public function create(): View
    {
        $applicableOptions = FeatureApplicableTo::cases();

        return view('admin.features.create', compact('applicableOptions'));
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        Feature::query()->create($request->validated());

        return redirect()->route('admin.features.index')->with('status', __('Feature created.'));
    }

    public function edit(Feature $feature): View
    {
        $applicableOptions = FeatureApplicableTo::cases();

        return view('admin.features.edit', compact('feature', 'applicableOptions'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature): RedirectResponse
    {
        $feature->update($request->validated());

        return redirect()->route('admin.features.index')->with('status', __('Feature updated.'));
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        return redirect()->route('admin.features.index')->with('status', __('Feature removed.'));
    }
}
