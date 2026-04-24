@extends('layouts.adminlte')

@section('title', __('Add category'))
@section('page_title', __('Add category'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.service-categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.service-categories.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Slug') }}</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required />
                    <div class="form-text">{{ __('e.g. room, desk') }}</div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
