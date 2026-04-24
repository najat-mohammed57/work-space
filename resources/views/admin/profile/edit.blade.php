@extends('layouts.adminlte')

@section('title', __('Profile Settings'))
@section('page_title', __('Profile Settings'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-edit mr-1"></i> {{ __('Personal Information') }}</h3>
                    </div>
                    <form action="{{ route('admin.profile.update') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-lock mr-1"></i> {{ __('Change Password') }}</h3>
                    </div>
                    <form action="{{ route('admin.profile.password.update') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Current Password') }}</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control" required />
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePass('current_password', 'icon1')" style="cursor: pointer;">
                                            <i class="bi bi-eye" id="icon1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('New Password') }}</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control" required />
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePass('new_password', 'icon2')" style="cursor: pointer;">
                                            <i class="bi bi-eye" id="icon2"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Confirm New Password') }}</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required />
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning">{{ __('Update Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
