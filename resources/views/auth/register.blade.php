@extends('layouts.guest')

@section('content')
<div class="register-page d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center align-items-center g-0">
            <div class="col-lg-5 d-none d-lg-block">
                <div class="register-info p-5 h-100 rounded-start-4 shadow-sm">
                    <h2 class="fw-bold mb-3 text-dark">Welcome to WorkSpace</h2>
                    <p class="mb-4 text-muted">
                        Join our professional community and book the workspace that fits your needs.
                    </p>

                    <div class="mb-3 text-dark">
                        <i class="fas fa-wifi me-2 text-primary"></i> High-speed internet
                    </div>
                    <div class="mb-3 text-dark">
                        <i class="fas fa-laptop me-2 text-primary"></i> Comfortable work environment
                    </div>
                    <div class="mb-3 text-dark">
                        <i class="fas fa-shield-alt me-2 text-primary"></i> Secure and private spaces
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-8">
                <div class="card register-card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <a href="{{ url('/') }}" class="h2 text-decoration-none">
                                <b>Work</b><span class="text-primary">Space</span>
                            </a>
                            <p class="text-muted mt-2 mb-0">Create your account</p>
                        </div>

                        <form action="{{ route('register.store') }}" method="post">
                            @csrf

                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-4">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                                Join Now
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                I already have a membership
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
