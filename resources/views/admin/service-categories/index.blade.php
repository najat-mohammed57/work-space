@extends('layouts.adminlte')

@section('title', __('Service categories'))
@section('page_title', __('Service categories'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Categories') }}</li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary">{{ __('Add category') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th class="text-end">{{ __('Types') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td class="text-end">{{ $category->service_types_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.service-categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form
                                    action="{{ route('admin.service-categories.destroy', $category) }}"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(@json(__('Delete this category? Child types and services will be removed.')));"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">{{ __('No categories.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="card-footer">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
