@extends('layouts.adminlte')

@section('title', __('Service types'))
@section('page_title', __('Service types'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Service types') }}</li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.service-types.create') }}" class="btn btn-primary">{{ __('Add service type') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th class="text-end">{{ __('Services') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($serviceTypes as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->serviceCategory?->name ?? '—' }}</td>
                            <td class="text-end">{{ $type->services_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.service-types.edit', $type) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form
                                    action="{{ route('admin.service-types.destroy', $type) }}"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(@json(__('Delete this service type?')));"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">{{ __('No service types.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($serviceTypes->hasPages())
            <div class="card-footer">{{ $serviceTypes->links() }}</div>
        @endif
    </div>
@endsection
