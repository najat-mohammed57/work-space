<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
        ->with(['serviceType.serviceCategory', 'features'])
        ->orderBy('name')
        ->get();

        return view('landing', compact('services'));
    }
}
