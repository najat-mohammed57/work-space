@extends('layouts.adminlte')

@section('title', __('Add customer'))
@section('page_title', __('Add customer'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.customers.store') }}" method="post">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" required autocomplete="new-password" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Confirm password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Company') }}</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Job title') }}</label>
                        <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ __('Notes') }}</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
