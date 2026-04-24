@extends('layouts.adminlte')

@section('title', __('Add reservation'))
@section('page_title', __('Add reservation'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">{{ __('Reservations') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
@endsection

@section('content')
    @php
        $startsAtValue = old('starts_at');
        if (is_string($startsAtValue) && str_contains($startsAtValue, ' ') && ! str_contains($startsAtValue, 'T')) {
            $startsAtValue = preg_replace('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})/', '$1T$2', $startsAtValue);
        }
        $endsAtValue = old('ends_at');
        if (is_string($endsAtValue) && str_contains($endsAtValue, ' ') && ! str_contains($endsAtValue, 'T')) {
            $endsAtValue = preg_replace('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})/', '$1T$2', $endsAtValue);
        }
    @endphp
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.reservations.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Service') }}</label>
                    <select name="service_id" id="reservation-service-select" class="form-select" required>
                        <option value="" data-effective-price="">{{ __('Choose…') }}</option>
                        @foreach ($services as $service)
                            <option
                                value="{{ $service->id }}"
                                data-effective-price="{{ number_format((float) $service->effective_price, 2, '.', '') }}"
                                data-currency="{{ $service->currency->value }}"
                                @selected(old('service_id') == $service->id)
                            >
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Customer') }}</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">{{ __('Choose…') }}</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Starts at') }}</label>
                        <input type="datetime-local" name="starts_at" class="form-control" value="{{ $startsAtValue }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Ends at') }}</label>
                        <input type="datetime-local" name="ends_at" class="form-control" value="{{ $endsAtValue }}" required />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select name="status" class="form-select">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', \App\Enums\ReservationStatus::Pending->value) === $status->value)>
                                {{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="reservation-price-panel" class="alert alert-info py-3 mb-3">
                    <p class="mb-1">
                        <strong>{{ __('Reservation total') }}:</strong>
                        <span id="reservation-price-value">{{ __('Select a service to see the price.') }}</span>
                    </p>
                    <p class="small mb-0 text-muted">
                        {{ __('This amount is saved automatically from the service’s effective price (after discount) and cannot be edited.') }}
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Notes') }}</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const serviceSelect = document.getElementById('reservation-service-select');
            const priceValueEl = document.getElementById('reservation-price-value');
            if (!serviceSelect || !priceValueEl) {
                return;
            }
            const emptyLabel = @json(__('Select a service to see the price.'));
            function formatMoney(value, currencyCode) {
                const n = Number.parseFloat(value);
                if (Number.isNaN(n)) {
                    return '—';
                }
                const code = currencyCode || 'USD';
                try {
                    return new Intl.NumberFormat(document.documentElement.lang || undefined, {
                        style: 'currency',
                        currency: code,
                    }).format(n);
                } catch {
                    return n.toFixed(2) + ' ' + code;
                }
            }
            function syncServicePrice() {
                const opt = serviceSelect.selectedOptions[0];
                if (!opt || !opt.value) {
                    priceValueEl.textContent = emptyLabel;
                    return;
                }
                const raw = opt.dataset.effectivePrice;
                if (raw === undefined || raw === '') {
                    priceValueEl.textContent = '—';
                    return;
                }
                priceValueEl.textContent = formatMoney(raw, opt.dataset.currency);
            }
            serviceSelect.addEventListener('change', syncServicePrice);
            syncServicePrice();
        });
    </script>
@endpush
