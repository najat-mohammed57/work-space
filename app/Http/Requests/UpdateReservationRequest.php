<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'starts_at' => ['sometimes', 'required_with:ends_at', 'date'],
            'ends_at' => ['sometimes', 'required_with:starts_at', 'date'],
            'status' => ['sometimes', new Enum(ReservationStatus::class)],
            'notes' => ['sometimes', 'nullable', 'string'],
            'total_amount' => ['prohibited'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            /** @var Reservation $reservation */
            $reservation = $this->route('reservation');

            if ($reservation->status === ReservationStatus::Cancelled && ($this->filled('starts_at') || $this->filled('ends_at'))) {
                $validator->errors()->add('starts_at', __('Cannot reschedule a cancelled reservation.'));
            }

            $startsAt = $this->date('starts_at') ?? $reservation->starts_at;
            $endsAt = $this->date('ends_at') ?? $reservation->ends_at;

            if ($this->has(['starts_at', 'ends_at']) && $endsAt <= $startsAt) {
                $validator->errors()->add('ends_at', __('The end time must be after the start time.'));
            }
        });
    }
}
