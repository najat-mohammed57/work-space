@extends('layouts.adminlte')

@section('title', __('Bookable services'))
@section('page_title', __('Bookable services'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Services') }}</li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">{{ __('Add service') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Code') }}</th>
                        <th>{{ __('Type / category') }}</th>
                        <th class="text-end">{{ __('Base price') }}</th>
                        <th class="text-center">{{ __('Currency') }}</th>
                        <th class="text-end">{{ __('Discount %') }}</th>
                        <th class="text-end">{{ __('Effective') }}</th>
                        <th class="text-center">{{ __('Active') }}</th>
                        <th class="text-end">{{ __('Features') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->code ?? '—' }}</td>
                            <td>
                                {{ $service->serviceType?->name ?? '—' }}
                                <span class="text-secondary small">({{ $service->serviceType?->serviceCategory?->slug ?? '—' }})</span>
                            </td>
                            <td class="text-end">{{ number_format((float) $service->base_price, 2) }}</td>
                            <td class="text-center"><span class="badge text-bg-light border">{{ $service->currency->value }}</span></td>
                            <td class="text-end">{{ number_format((float) ($service->discount_percent ?? 0), 2) }}</td>
                            <td class="text-end">{{ number_format((float) $service->effective_price, 2) }} {{ $service->currency->value }}</td>
                            <td class="text-center">
                                @if ($service->is_active)
                                    <span class="badge text-bg-success">{{ __('Yes') }}</span>
                                @else
                                    <span class="badge text-bg-secondary">{{ __('No') }}</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $service->features_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form
                                    action="{{ route('admin.services.destroy', $service) }}"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(@json(__('Delete this service?')));"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-secondary py-4">{{ __('No services.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($services->hasPages())
            <div class="card-footer">{{ $services->links() }}</div>
        @endif
    </div>
@endsection
