<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time'   => ['required'],
            'end_time'     => ['required', 'after:start_time'],
            'phone'        => ['required', 'string', 'max:20'],
            'company'      => ['nullable', 'string', 'max:100'],
            'job_title'    => ['nullable', 'string', 'max:100'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
      return [
    'booking_date.after_or_equal' => 'The booking date cannot be in the past',
    'end_time.after' => 'Invalid time range: End time must be after start time',
];
    }
}
