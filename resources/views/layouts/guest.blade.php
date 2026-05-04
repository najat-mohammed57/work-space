<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>WorkSpace Gaza</title>
        @include('layouts.partials.adminlte-head')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

 <style>
 body {
 font-family: 'Inter', sans-serif;
  scroll-behavior: smooth;
 }

.gz-logo-container { position: relative; width: 40px; height: 24px; }
.circle { width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; color: white; position: absolute; border: 2px solid #fff; }
.circle-g { background-color: #007bff; left: 0; z-index: 2; }
.circle-z { background-color: #000; left: 14px; z-index: 1; }
.pill-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    flex-shrink: 0;
    font-size: 0.75rem;
}


.custom-pill {
    display: inline-flex !important;
    align-items: center;
    padding: 2px 12px 2px 4px !important;
    border-radius: 50px !important;
    background-color: #fff;
    white-space: nowrap;
    transition: all 0.2s ease;
    height: 32px;
}

.pill-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #212529;
    line-height: 1;
}

.custom-pill:active {
    transform: scale(0.96);
}

.flex-grow-1 {
    flex-grow: 1 !important;
}
   .custom-muted-text {
        color: #adb5bd !important;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .social-icon {
        width: 45px;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-icon.facebook:hover { background-color: #1877f2; transform: translateY(-5px); }
    .social-icon.instagram:hover { background-color: #e4405f; transform: translateY(-5px); }
    .social-icon.whatsapp:hover { background-color: #25d366; transform: translateY(-5px); }

    .social-links {
        gap: 15px;
    }
    .nav-custom-link {
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.nav-custom-link:hover {
    transform: translateY(-3px);
    filter: contrast(1.5) brightness(0.8);
    text-shadow: 0px 2px 4px rgba(0,0,0,0.1);
}

.nav-custom-link:active {
    transform: translateY(0px);
    opacity: 0.7;
}
</style>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="/">
            <div class="gz-logo-container me-2">
                <span class="circle circle-g">G</span>
                <span class="circle circle-z">Z</span>
            </div>
            <span class="fw-bold text-dark">Work<span class="text-primary">Space</span></span>
        </a>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav d-flex flex-row gap-4">
                <li class="nav-item">
                    <a class="nav-link fw-medium p-0" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium p-0" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium p-0" href="#footer">Contact</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-3 ms-auto">
            @guest

                <a href="{{ route('login') }}" class="text-secondary small text-decoration-none">Manager?</a>
                <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Join Now</a>
            @endguest
@auth
 @if(auth()->user()->is_admin)
    <div class="dropdown">
      <a class="custom-pill admin-pill-style dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
    <div class="pill-avatar bg-primary">
        <i class="fas fa-user-shield text-white"></i>
    </div>
    <span class="pill-label">Admin: {{ auth()->user()->name }}</span>
</a>

        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-15 mt-2" aria-labelledby="adminDropdown">
            <li class="px-3 py-2 text-muted small fw-bold text-uppercase border-bottom mb-1">Management</li>
            <li>
                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                    <i class="bi bi-people me-2 text-primary"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li><hr class="dropdown-divider opacity-50"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="px-2">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger rounded-10 d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
    @else
        <div class="dropdown">
      <a class="custom-pill user-border dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
    <div class="pill-avatar-simple me-2">
        <i class="bi bi-person-circle text-primary fs-5"></i>
    </div>
    <span class="pill-label">Welcome, {{ auth()->user()->name }}</span>
</a>

            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-15 mt-2" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('bookings.index') }}">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>My Bookings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Profile Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider opacity-50"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="px-2">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger rounded-10">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endif
@endauth
        </div>
    </div>
</nav>

        <!-- Dynamic Content -->
        <main class="flex-grow-1 py-5">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer id="footer" class="bg-dark text-white py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h4 class="text-primary font-bold mb-3">GZ WorkSpace</h4>
                <p class="custom-muted-text mx-auto mb-4" style="max-width: 500px;">
                    Empowering Gaza's community with professional workspaces and high-speed connectivity.
                </p>
            </div>

            <div class="col-md-6">
                <h4 class="font-bold mb-3">Connect With Us</h4>

                <div class="social-links d-flex justify-content-center gap-3">
                    <a href="#" class="social-icon facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/YOUR_NUMBER" class="social-icon whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>

                <div class="mt-3">
                    <a href="#" class="custom-muted-text small text-decoration-none mx-2">Privacy Policy</a>
                    <a href="#" class="custom-muted-text small text-decoration-none mx-2">Terms of Service</a>
                </div>
            </div>

            <div class="col-12">
                <hr class="mt-5 border-secondary opacity-25">
                <p class="custom-muted-text small mb-0 text-center">
                    &copy; {{ date('Y') }} GZ WorkSpace. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

        @include('layouts.partials.adminlte-scripts')
    </body>
</html>
