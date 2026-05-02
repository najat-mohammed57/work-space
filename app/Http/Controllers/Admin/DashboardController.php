<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $customerCount = Customer::query()->count();
        $serviceCount = Service::query()->count();
        $activeServiceCount = Service::query()->where('is_active', true)->count();
        $reservationCount = Reservation::query()->count();
        $featureCount = Feature::query()->count();

        return view('admin.dashboard', [
            'customerCount' => $customerCount,
            'serviceCount' => $serviceCount,
            'activeServiceCount' => $activeServiceCount,
            'reservationCount' => $reservationCount,
            'featureCount' => $featureCount,
        ]);
    }
} 
