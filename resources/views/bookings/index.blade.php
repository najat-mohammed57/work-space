@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <h2 class="font-bold mb-4">My Bookings</h2>

    <div class="card border-0 shadow-sm rounded-15">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="p-3">Service</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Time</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="p-3">{{ $booking->service->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($booking->starts_at)->format('Y-m-d') }}</td>
                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($booking->starts_at)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($booking->ends_at)->format('H:i') }}
                        </td>
                        <td class="p-3">
                            <span class="badge bg-success">Confirmed</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center p-5 text-muted">You have no bookings yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
