@extends('layouts.adminlte')

@section('title', __('Edit reservation'))
@section('page_title', __('Edit reservation'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">{{ __('Reservations') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
@endsection

@section('content')
    @php
        $startsAtValue = old('starts_at', $reservation->starts_at->format('Y-m-d\TH:i'));
        if (is_string($startsAtValue) && str_contains($startsAtValue, ' ') && ! str_contains($startsAtValue, 'T')) {
            $startsAtValue = preg_replace('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})/', '$1T$2', $startsAtValue);
        }
        $endsAtValue = old('ends_at', $reservation->ends_at->format('Y-m-d\TH:i'));
        if (is_string($endsAtValue) && str_contains($endsAtValue, ' ') && ! str_contains($endsAtValue, 'T')) {
            $endsAtValue = preg_replace('/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})/', '$1T$2', $endsAtValue);
        }
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <p class="mb-1"><strong>{{ __('Service') }}:</strong> {{ $reservation->service?->name ?? '—' }}</p>
            @if ($reservation->service)
                <p class="mb-1">
                    <strong>{{ __('Current catalog price') }}:</strong>
                    {{ number_format((float) $reservation->service->effective_price, 2) }}
                    {{ $reservation->service->currency->value }}
                </p>
            @endif
            <p class="mb-0"><strong>{{ __('Customer') }}:</strong> {{ $reservation->customer?->name ?? '—' }} ({{ $reservation->customer?->email }})</p>
            <p class="text-secondary small mb-0">{{ __('To change service or customer, create a new reservation and cancel this one if needed.') }}</p>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.reservations.update', $reservation) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
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
                            <option value="{{ $status->value }}" @selected(old('status', $reservation->status->value) === $status->value)>
                                {{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Total amount') }}</label>
                    <p class="form-control-plaintext border rounded px-3 py-2 bg-light mb-0">
                        {{ number_format((float) $reservation->total_amount, 2) }}
                        @if ($reservation->service)
                            {{ $reservation->service->currency->value }}
                        @endif
                    </p>
                    <div class="form-text">{{ __('Fixed when the reservation was created from the service price; it cannot be edited.') }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Notes') }}</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $reservation->notes) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
