@extends('layouts.adminlte')

@section('title', __('Features'))
@section('page_title', __('Features'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Features') }}</li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.features.create') }}" class="btn btn-primary">{{ __('Add feature') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Applicable to') }}</th>
                        <th class="text-end">{{ __('Services') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($features as $feature)
                        <tr>
                            <td>{{ $feature->name }}</td>
                            <td><span class="badge text-bg-secondary">{{ $feature->applicable_to->value }}</span></td>
                            <td class="text-end">{{ $feature->services_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form
                                    action="{{ route('admin.features.destroy', $feature) }}"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(@json(__('Delete this feature?')));"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">{{ __('No features.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($features->hasPages())
            <div class="card-footer">{{ $features->links() }}</div>
        @endif
    </div>
@endsection
