@extends('layouts.adminlte')

@section('title', __('Edit feature'))
@section('page_title', __('Edit feature'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.features.index') }}">{{ __('Features') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.features.update', $feature) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $feature->name) }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Applicable to') }}</label>
                    <select name="applicable_to" class="form-select" required>
                        @foreach ($applicableOptions as $opt)
                            <option value="{{ $opt->value }}" @selected(old('applicable_to', $feature->applicable_to->value) === $opt->value)>
                                {{ $opt->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
