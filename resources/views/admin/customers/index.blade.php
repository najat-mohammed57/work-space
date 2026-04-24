@extends('layouts.adminlte')

@section('title', __('Customers'))
@section('page_title', __('Customers'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Customers') }}</li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">{{ __('Add customer') }}</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('All customers') }}</h3>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Job title') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company_name ?? '—' }}</td>
                            <td>{{ $customer->job_title ?? '—' }}</td>
                            <td>{{ $customer->phone ?? '—' }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form
                                    action="{{ route('admin.customers.destroy', $customer) }}"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(@json(__('Delete this customer?')));"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">{{ __('No customers yet.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($customers->hasPages())
            <div class="card-footer">{{ $customers->links() }}</div>
        @endif
    </div>
@endsection
