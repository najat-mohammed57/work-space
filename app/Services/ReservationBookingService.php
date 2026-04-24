<?php

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReservationBookingService
{
    public function assertNoOverlap(int $serviceId, DateTimeInterface|string $startsAt, DateTimeInterface|string $endsAt, ?int $ignoreReservationId = null): void
    {
        $startsAt = $this->parseDateTime($startsAt);
        $endsAt = $this->parseDateTime($endsAt);

        if ($startsAt >= $endsAt) {
            throw ValidationException::withMessages([
                'ends_at' => __('The end time must be after the start time.'),
            ]);
        }

        $hasOverlap = Reservation::query()
            ->where('service_id', $serviceId)
            ->whereNot('status', ReservationStatus::Cancelled)
            ->when($ignoreReservationId, fn ($q) => $q->whereKeyNot($ignoreReservationId))
            ->where(function ($query) use ($startsAt, $endsAt) {
                $query->where('starts_at', '<', $endsAt)
                    ->where('ends_at', '>', $startsAt);
            })
            ->exists();

        if ($hasOverlap) {
            throw ValidationException::withMessages([
                'starts_at' => __('This service is already reserved for part of this interval.'),
            ]);
        }
    }

    public function createReservation(Service $service, Customer $customer, array $attributes): Reservation
    {
        return DB::transaction(function () use ($service, $customer, $attributes) {
            Reservation::query()->where('service_id', $service->id)->lockForUpdate()->first();

            $startsAt = $this->parseDateTime($attributes['starts_at']);
            $endsAt = $this->parseDateTime($attributes['ends_at']);

            $this->assertNoOverlap($service->id, $startsAt, $endsAt);

            $pricedService = $service->fresh() ?? $service;

            return Reservation::query()->create([
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => $attributes['status'] ?? ReservationStatus::Pending,
                'total_amount' => round((float) $pricedService->effective_price, 2),
                'notes' => $attributes['notes'] ?? null,
            ]);
        });
    }

    public function updateSchedule(Reservation $reservation, DateTimeInterface|string $startsAt, DateTimeInterface|string $endsAt): void
    {
        DB::transaction(function () use ($reservation, $startsAt, $endsAt) {
            Reservation::query()->where('service_id', $reservation->service_id)->lockForUpdate()->first();

            if ($reservation->status === ReservationStatus::Cancelled) {
                throw ValidationException::withMessages([
                    'status' => __('Cancelled reservations cannot be rescheduled.'),
                ]);
            }

            $startsAt = $this->parseDateTime($startsAt);
            $endsAt = $this->parseDateTime($endsAt);

            $this->assertNoOverlap($reservation->service_id, $startsAt, $endsAt, $reservation->id);

            $reservation->forceFill([
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
            ])->save();
        });
    }

    private function parseDateTime(DateTimeInterface|string $value): Carbon
    {
        return Carbon::parse($value);
    }
}
