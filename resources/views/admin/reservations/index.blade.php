@extends('layouts.adminlte')

@section('title', $showingTrashed ? __('Trashed reservations') : __('Reservations'))
@section('page_title', $showingTrashed ? __('Trashed reservations') : __('Reservations'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    @if ($showingTrashed)
        <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">{{ __('Reservations') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Trash') }}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{ __('Reservations') }}</li>
    @endif
@endsection

@section('content')
    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
        @if ($showingTrashed)
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">{{ __('Active reservations') }}</a>
        @else
            <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">{{ __('Add reservation') }}</a>
            @if ($trashedCount > 0)
                <a href="{{ route('admin.reservations.index', ['trashed' => 1]) }}" class="btn btn-outline-warning">
                    {{ __('Trash') }}
                    <span class="badge text-bg-warning ms-1">{{ $trashedCount }}</span>
                </a>
            @endif
        @endif
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Starts') }}</th>
                        <th>{{ __('Ends') }}</th>
                        @if ($showingTrashed)
                            <th>{{ __('Deleted at') }}</th>
                        @endif
                        <th>{{ __('Service') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Total') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr @if ($showingTrashed) class="table-warning" @endif>
                            <td>{{ $reservation->starts_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $reservation->ends_at->format('Y-m-d H:i') }}</td>
                            @if ($showingTrashed)
                                <td>{{ $reservation->deleted_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            @endif
                            <td>{{ $reservation->service?->name ?? '—' }}</td>
                            <td>
                                {{ $reservation->customer?->name ?? '—' }}
                                @if ($reservation->customer?->company_name)
                                    <div class="small text-secondary">{{ $reservation->customer->company_name }}</div>
                                @endif
                            </td>
                            <td><span class="badge text-bg-secondary">{{ $reservation->status->value }}</span></td>
                            <td class="text-end text-nowrap">
                                @if ($reservation->total_amount !== null)
                                    {{ number_format((float) $reservation->total_amount, 2) }}
                                    {{ $reservation->service?->currency->value ?? '' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @if ($showingTrashed)
                                    <form
                                        action="{{ route('admin.reservations.restore', $reservation) }}"
                                        method="post"
                                        class="d-inline"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">{{ __('Restore') }}</button>
                                    </form>
                                    <form
                                        action="{{ route('admin.reservations.force', $reservation) }}"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm(@json(__('Permanently delete this reservation? This cannot be undone.')));"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete forever') }}</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                    <form
                                        action="{{ route('admin.reservations.destroy', $reservation) }}"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm(@json(__('Move this reservation to trash?')));"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Trash') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $showingTrashed ? 8 : 7 }}" class="text-center text-secondary py-4">
                                {{ $showingTrashed ? __('No trashed reservations.') : __('No reservations.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($reservations->hasPages())
            <div class="card-footer">{{ $reservations->links() }}</div>
        @endif
    </div>
@endsection
