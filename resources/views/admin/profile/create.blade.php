@extends('layouts.adminlte')

@section('title', __('Add Admin'))
@section('page_title', __('Add Admin'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add Admin') }}</li>
@endsection

@section('content')
    <div class="card card-success card-outline">
        <form action="{{ route('admin.admins.store') }}" method="post">
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
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="example@mail.com" required />

                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password" />
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePass('password', 'icon1')" style="cursor: pointer;">
                                    <i class="bi bi-eye" id="icon1"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('Confirm password') }}</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password" />
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePass('password_confirmation', 'icon2')" style="cursor: pointer;">
                                    <i class="bi bi-eye" id="icon2"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                <a href="{{ route('admin.admins.create') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>


    <script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
    </script>
@endsection
