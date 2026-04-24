<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Service;
use App\Services\ReservationBookingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function __construct(
        protected ReservationBookingService $booking,
    ) {}

    public function index(Request $request): View
    {
        $showingTrashed = $request->boolean('trashed');

        $query = Reservation::query()
            ->with(['service.serviceType.serviceCategory', 'customer']);

        if ($showingTrashed) {
            $query->onlyTrashed()->orderByDesc('deleted_at');
        } else {
            $query->orderByDesc('starts_at');
        }

        $reservations = $query->paginate(20)->withQueryString();

        $trashedCount = $showingTrashed ? 0 : Reservation::onlyTrashed()->count();

        return view('admin.reservations.index', compact('reservations', 'showingTrashed', 'trashedCount'));
    }

    public function create(): View
    {
        $services = Service::query()->where('is_active', true)->orderBy('name')->get();
        $customers = Customer::query()->orderBy('name')->get();
        $statuses = ReservationStatus::cases();

        return view('admin.reservations.create', compact('services', 'customers', 'statuses'));
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $this->authorize('create', Reservation::class);

        $data = $request->validated();
        $service = Service::query()->findOrFail($data['service_id']);
        $customer = Customer::query()->findOrFail($data['customer_id']);

        $this->booking->createReservation($service, $customer, [
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'status' => $data['status'] ?? ReservationStatus::Pending,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('admin.reservations.index')->with('status', __('Reservation created.'));
    }

    public function edit(Reservation $reservation): View
    {
        $this->authorize('update', $reservation);

        $reservation->loadMissing(['service', 'customer']);

        $statuses = ReservationStatus::cases();

        return view('admin.reservations.edit', compact('reservation', 'statuses'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation): RedirectResponse
    {
        $this->authorize('update', $reservation);

        $data = $request->validated();

        if (isset($data['starts_at'], $data['ends_at'])) {
            $this->booking->updateSchedule($reservation, $data['starts_at'], $data['ends_at']);
            $reservation->refresh();
        }

        foreach (['status', 'notes'] as $field) {
            if (array_key_exists($field, $data)) {
                $reservation->{$field} = $data[$field];
            }
        }

        $reservation->save();

        return redirect()->route('admin.reservations.index')->with('status', __('Reservation updated.'));
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('status', __('Reservation moved to trash.'));
    }

    public function restore(Reservation $reservation): RedirectResponse
    {
        $this->authorize('restore', $reservation);

        $reservation->restore();

        return redirect()->route('admin.reservations.index')->with('status', __('Reservation restored.'));
    }

    public function forceDestroy(Reservation $reservation): RedirectResponse
    {
        $this->authorize('forceDelete', $reservation);

        $reservation->forceDelete();

        return redirect()->route('admin.reservations.index', ['trashed' => 1])->with('status', __('Reservation permanently deleted.'));
    }
}
