<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.adminlte-head')
    </head>
    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        <div class="app-wrapper">
            <nav class="app-header navbar navbar-expand bg-body">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                <i class="bi bi-list"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                  <a href="{{ url('/') }}" class="nav-link">
                        | Visit Website
                </a>
               </li>
                    </ul>
                   <ul class="navbar-nav ms-auto">
                 <li class="nav-item dropdown user-menu">
               <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 220px;">
            <li class="user-header text-bg-secondary p-3 text-center">
                <i class="bi bi-person-badge fs-2"></i>
                <p class="mb-0 small">{{ auth()->user()->email }}</p>
            </li>
            <li>
                <a href="{{ route('admin.profile.edit') }}" class="dropdown-item py-2">
                    <i class="bi bi-person-gear me-2"></i> Edit Your Profile
                </a>
            </li>
          <li>
        <a href="{{ route('admin.profile.password.edit') }}" class="dropdown-item py-2">
           <i class="bi bi-shield-lock me-2"></i> Change Password
          </a>
           </li>
           <li>
    <a href="{{ route('admin.admins.create') }}" class="dropdown-item py-2">
        <i class="bi bi-person-plus me-2"></i> Add New Admin
    </a>
</li>

            <li><hr class="dropdown-divider m-0"></li>

            <li class="p-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> {{ __('Sign out') }}
                    </button>
                </form>
            </li>
        </ul>
    </li>
</ul>
                </div>
            </nav>

            <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
                <div class="sidebar-brand">
                    <a href="{{ route('admin.dashboard') }}" class="brand-link">
                        <img
                            src="{{ asset('vendor/adminlte/assets/img/AdminLTELogo.png') }}"
                            alt="Logo"
                            class="brand-image opacity-75 shadow"
                        />
                        <span class="brand-text fw-light">{{ __('Workspace') }}</span>
                    </a>
                </div>
                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <ul
                            class="nav sidebar-menu flex-column"
                            data-lte-toggle="treeview"
                            role="navigation"
                            aria-label="Main navigation"
                            data-accordion="false"
                        >
                            <li class="nav-item">
                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    class="nav-link @if (request()->routeIs('admin.dashboard')) active @endif"
                                >
                                    <i class="nav-icon bi bi-speedometer2"></i>
                                    <p>{{ __('Dashboard') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="{{ route('admin.customers.index') }}"
                                    class="nav-link @if (request()->routeIs('admin.customers.*')) active @endif"
                                >
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>{{ __('Customers') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-grid"></i>
                                    <p>
                                        {{ __('Catalog') }}
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('admin.service-categories.index') }}"
                                            class="nav-link @if (request()->routeIs('admin.service-categories.*')) active @endif"
                                        >
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>{{ __('Categories') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('admin.service-types.index') }}"
                                            class="nav-link @if (request()->routeIs('admin.service-types.*')) active @endif"
                                        >
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>{{ __('Service types') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('admin.features.index') }}"
                                            class="nav-link @if (request()->routeIs('admin.features.*')) active @endif"
                                        >
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>{{ __('Features') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('admin.services.index') }}"
                                            class="nav-link @if (request()->routeIs('admin.services.*')) active @endif"
                                        >
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>{{ __('Bookable services') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="{{ route('admin.reservations.index') }}"
                                    class="nav-link @if (request()->routeIs('admin.reservations.*')) active @endif"
                                >
                                    <i class="nav-icon bi bi-calendar-check"></i>
                                    <p>{{ __('Reservations') }}</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <main class="app-main">
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">@yield('page_title')</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-content">
                    <div class="container-fluid">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </main>

<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">
        {{ env('APP_NAME')}} | <b>Version</b> {{ env('APP_Version') }}
    </div>

    <strong>
        Copyright &copy; {{ now()->year }}-{{ now()->year + 1 }}
        <span class="text-primary">Workspace</span>
        <a href="#" class="text-decoration-none">{{ env('APP_NAME')}}</a>
    </strong>
</footer>
        </div>
        @include('layouts.partials.adminlte-scripts')
    </body>
</html>
