@extends('layouts.guest')

@section('title', __('Manager sign in'))

@section('content')

    <div class="d-flex align-items-center justify-content-center min-vh-100 py-4">

        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('home') }}"><b>{{ config('app.name') }}</b></a>
            </div>

            <div class="card shadow-lg">
                <div class="card-body login-card-body rounded">
                    <p class="login-box-msg">{{ __('Sign in to the manager panel') }}</p>

                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email') }}"
                                required
                                autofocus
                            />
                            <div class="input-group-text">
                                <span class="bi bi-envelope"></span>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block w-100">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('Password') }}"
                                required
                            />
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-7">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember" />
                                    <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Sign in') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <p class="mb-0 mt-4 text-center">
                        <a href="{{ route('home') }}" class="text-secondary small">{{ __('Back to site') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
