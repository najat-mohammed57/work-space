@extends('layouts.adminlte')

@section('title', __('Dashboard'))
@section('page_title', __('Dashboard'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $customerCount }}</h3>
                    <p>{{ __('Customers') }}</p>
                </div>
                <i class="bi bi-people small-box-icon"></i>
                <a href="{{ route('admin.customers.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                    {{ __('View') }} <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $activeServiceCount }} <span class="fs-6">/ {{ $serviceCount }}</span></h3>
                    <p>{{ __('Active / total services') }}</p>
                </div>
                <i class="bi bi-building small-box-icon"></i>
                <a href="{{ route('admin.services.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                    {{ __('View') }} <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $reservationCount }}</h3>
                    <p>{{ __('Reservations') }}</p>
                </div>
                <i class="bi bi-calendar-check small-box-icon"></i>
                <a href="{{ route('admin.reservations.index') }}" class="small-box-footer link-dark link-underline-opacity-0">
                    {{ __('View') }} <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $featureCount }}</h3>
                    <p>{{ __('Features') }}</p>
                </div>
                <i class="bi bi-tags small-box-icon"></i>
                <a href="{{ route('admin.features.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                    {{ __('View') }} <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
