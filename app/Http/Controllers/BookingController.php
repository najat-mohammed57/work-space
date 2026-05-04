<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Reservation;
use App\Http\Requests\StoreBookingRequest;
use Carbon\Carbon;
use App\Services\ReservationBookingService;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

public function index()
{
    $user = auth()->user();
    
    $bookings = $user->customer->reservations()->with('service')->latest()->get();

    return view('bookings.index', compact('bookings'));
}
    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

public function store(StoreBookingRequest $request, Service $service, ReservationBookingService $bookingService)
{
    $data = $request->validated();
    $user = Auth::user();

    /** @var \App\Models\Customer $customer */
    $customer = $user->customer;

    if (!$customer) {
        return back()->withErrors(['error' => 'No customer profile found.']);
    }
    try {
    $customer->fill([
        'phone'        => $data['phone'] ?? $customer->phone,
        'company_name' => $data['company'] ?? $customer->company_name,
        'job_title'    => $data['job_title'] ?? $customer->job_title,
    ]);

    $customer->save();

    $bookingService->createReservation($service, $customer, [
        'starts_at' => $data['booking_date'] . ' ' . $data['start_time'],
        'ends_at'   => $data['booking_date'] . ' ' . $data['end_time'],
        'notes'     => $data['notes'] ?? null,
    ]);
    return redirect('/')->with('booking_success', 'Reservation confirmed successfully!');
    }
    catch (\Exception $e)
     {
    return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}
}
