@extends('layouts.adminlte')

@section('title', __('Edit service'))
@section('page_title', __('Edit service'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">{{ __('Services') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.services.update', $service) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Service type') }}</label>
                    <select name="service_type_id" id="admin-service-type-select" class="form-select" required>
                        @foreach ($serviceTypes as $type)
                            <option
                                value="{{ $type->id }}"
                                data-category-slug="{{ $type->serviceCategory?->slug ?? '' }}"
                                @selected(old('service_type_id', $service->service_type_id) == $type->id)
                            >
                                {{ $type->name }} ({{ $type->serviceCategory?->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Code') }}</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $service->code) }}" />
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('Base price') }}</label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="base_price"
                            class="form-control"
                            value="{{ old('base_price', $service->base_price) }}"
                            required
                        />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('Currency') }}</label>
                        <select name="currency" class="form-select" required>
                            @foreach (\App\Enums\ServiceCurrency::cases() as $currency)
                                <option value="{{ $currency->value }}" @selected(old('currency', $service->currency->value) === $currency->value)>
                                    {{ $currency->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('Discount %') }}</label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            name="discount_percent"
                            class="form-control"
                            value="{{ old('discount_percent', $service->discount_percent) }}"
                        />
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0" />
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="form-check-input"
                        id="is_active"
                        @checked(old('is_active', $service->is_active))
                    />
                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Features') }}</label>
                    <div class="row" id="admin-service-features">
                        @php($selected = old('feature_ids', $service->features->pluck('id')->all()))
                        @foreach ($features as $feature)
                            <div class="col-md-4 js-service-feature-row" data-applicable="{{ $feature->applicable_to->value }}">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="feature_ids[]"
                                        value="{{ $feature->id }}"
                                        id="f{{ $feature->id }}"
                                        @checked(in_array((int) $feature->id, array_map('intval', (array) $selected), true))
                                    />
                                    <label class="form-check-label" for="f{{ $feature->id }}">{{ $feature->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('admin-service-type-select');
            const rows = document.querySelectorAll('.js-service-feature-row');
            if (!typeSelect || !rows.length) {
                return;
            }
            function selectedCategorySlug() {
                const opt = typeSelect.selectedOptions[0];
                return opt && opt.dataset.categorySlug !== undefined ? opt.dataset.categorySlug : '';
            }
            function syncFeatureRows() {
                const slug = selectedCategorySlug();
                rows.forEach(function (row) {
                    const applicable = row.dataset.applicable || '';
                    const visible = applicable === 'all' || applicable === slug;
                    row.classList.toggle('d-none', !visible);
                    if (!visible) {
                        const cb = row.querySelector('input[type="checkbox"][name="feature_ids[]"]');
                        if (cb) {
                            cb.checked = false;
                        }
                    }
                });
            }
            typeSelect.addEventListener('change', syncFeatureRows);
            syncFeatureRows();
        });
    </script>
@endpush
