<?php

use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeaturesController;
use App\Http\Controllers\Admin\ReservationsController;
use App\Http\Controllers\Admin\ServiceCategoriesController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ServiceTypesController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\SessionAuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [SessionAuthController::class, 'create'])->name('login');
});

Route::post('/login', [SessionAuthController::class, 'store'])
    ->middleware(['guest', 'throttle:10,1']);

Route::post('/logout', [SessionAuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomersController::class);
    Route::resource('service-categories', ServiceCategoriesController::class);
    Route::resource('service-types', ServiceTypesController::class);
    Route::resource('features', FeaturesController::class);
    Route::resource('services', ServicesController::class);
    Route::post('reservations/{reservation}/restore', [ReservationsController::class, 'restore'])
        ->name('reservations.restore')
        ->withTrashed();
    Route::delete('reservations/{reservation}/force', [ReservationsController::class, 'forceDestroy'])
        ->name('reservations.force')
        ->withTrashed();
    Route::resource('reservations', ReservationsController::class);

Route::prefix('profile')->name('profile.')->group(function (): void {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');

    Route::get('/change-password', [ProfileController::class, 'edit'])->name('password.edit');
    Route::post('/password-update', [ProfileController::class, 'passwordUpdate'])->name('password.update');
});

Route::prefix('admins')->name('admins.')->group(function () {
    Route::get('/create', [ProfileController::class, 'createAdmin'])->name('create');
    Route::post('/store', [ProfileController::class, 'storeAdmin'])->name('store');
});

});


