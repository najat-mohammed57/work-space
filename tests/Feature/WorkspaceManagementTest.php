<?php

use App\Enums\FeatureApplicableTo;
use App\Enums\ReservationStatus;
use App\Enums\ServiceCurrency;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\User;

function createTestManager(array $overrides = []): User
{
    return User::query()->create(array_merge([
        'name' => 'Test Manager',
        'email' => uniqid('manager-', true).'@example.test',
        'password' => 'password',
    ], $overrides));
}

function createTestCustomer(array $overrides = []): Customer
{
    return Customer::factory()->create(array_merge([
        'name' => 'Test Customer',
        'email' => uniqid('customer-', true).'@example.test',
        'password' => 'password',
    ], $overrides));
}

test('customers admin requires authentication', function () {
    $this->get(route('admin.customers.index'))
        ->assertRedirect(route('login'));
});

test('managers can create customers', function () {
    $manager = createTestManager();

    $this->actingAs($manager)
        ->post(route('admin.customers.store'), [
            'name' => 'Acme Contact',
            'email' => 'contact@acme.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'company_name' => 'Acme Inc',
            'job_title' => 'Ops',
            'phone' => '+100000000',
        ])
        ->assertRedirect(route('admin.customers.index'))
        ->assertSessionHas('status');

    expect(Customer::query()->where('email', 'contact@acme.test')->value('company_name'))->toBe('Acme Inc');
});

test('managers cannot create customers with a duplicate email', function () {
    createTestCustomer(['email' => 'taken@example.com']);
    $manager = createTestManager();

    $this->actingAs($manager)
        ->post(route('admin.customers.store'), [
            'name' => 'Other Person',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertSessionHasErrors('email');
});

test('admin customer form rejects duplicate email with validation', function () {
    createTestCustomer(['email' => 'dup@example.com']);
    $manager = createTestManager();

    $this->actingAs($manager)
        ->from(route('admin.customers.create'))
        ->post(route('admin.customers.store'), [
            'name' => 'X',
            'email' => 'dup@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertRedirect(route('admin.customers.create'))
        ->assertSessionHasErrors('email');
});

test('overlapping reservations for the same service are rejected', function () {
    $manager = createTestManager();
    $customer = createTestCustomer();

    $category = ServiceCategory::query()->create(['name' => 'Room', 'slug' => 'room']);
    $type = ServiceType::query()->create(['service_category_id' => $category->id, 'name' => 'Meeting']);
    $service = Service::query()->create([
        'service_type_id' => $type->id,
        'name' => 'Overlap test service',
        'code' => 'OVR-'.uniqid(),
        'base_price' => 100,
        'currency' => ServiceCurrency::Usd,
        'discount_percent' => 0,
        'is_active' => true,
    ]);

    Reservation::query()->create([
        'service_id' => $service->id,
        'customer_id' => $customer->id,
        'starts_at' => now()->addDay()->setTime(10, 0),
        'ends_at' => now()->addDay()->setTime(12, 0),
        'status' => ReservationStatus::Confirmed,
        'total_amount' => 100.00,
    ]);

    $this->actingAs($manager)
        ->from(route('admin.reservations.create'))
        ->post(route('admin.reservations.store'), [
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'starts_at' => now()->addDay()->setTime(11, 0)->format('Y-m-d\TH:i'),
            'ends_at' => now()->addDay()->setTime(13, 0)->format('Y-m-d\TH:i'),
            'status' => ReservationStatus::Pending->value,
        ])
        ->assertSessionHasErrors('starts_at');
});

test('features must be compatible with the service category', function () {
    $manager = createTestManager();

    $roomCategory = ServiceCategory::query()->create(['name' => 'Room', 'slug' => 'room']);
    $deskFeature = Feature::query()->create([
        'name' => 'Desk-only feature',
        'applicable_to' => FeatureApplicableTo::Desk,
    ]);
    $type = ServiceType::query()->create(['service_category_id' => $roomCategory->id, 'name' => 'Meeting']);

    $this->actingAs($manager)
        ->from(route('admin.services.create'))
        ->post(route('admin.services.store'), [
            'service_type_id' => $type->id,
            'name' => 'Room A',
            'base_price' => 50,
            'currency' => 'USD',
            'discount_percent' => 0,
            'is_active' => 1,
            'feature_ids' => [$deskFeature->id],
        ])
        ->assertSessionHasErrors('feature_ids');
});

test('managers can trash and restore reservations in admin', function () {
    $manager = createTestManager();
    $customer = createTestCustomer();

    $category = ServiceCategory::query()->create(['name' => 'Room', 'slug' => 'room']);
    $type = ServiceType::query()->create(['service_category_id' => $category->id, 'name' => 'Meeting']);
    $service = Service::query()->create([
        'service_type_id' => $type->id,
        'name' => 'Trash test service',
        'code' => 'TRS-'.uniqid(),
        'base_price' => 80,
        'currency' => ServiceCurrency::Usd,
        'discount_percent' => 0,
        'is_active' => true,
    ]);

    $reservation = Reservation::query()->create([
        'service_id' => $service->id,
        'customer_id' => $customer->id,
        'starts_at' => now()->addDay()->setTime(10, 0),
        'ends_at' => now()->addDay()->setTime(12, 0),
        'status' => ReservationStatus::Pending,
        'total_amount' => 80.00,
    ]);

    $this->actingAs($manager)
        ->from(route('admin.reservations.index'))
        ->delete(route('admin.reservations.destroy', $reservation))
        ->assertRedirect(route('admin.reservations.index'));

    expect(Reservation::query()->find($reservation->id))->toBeNull();

    $this->actingAs($manager)
        ->post(route('admin.reservations.restore', $reservation))
        ->assertRedirect(route('admin.reservations.index'));

    expect(Reservation::query()->find($reservation->id))->not->toBeNull();
});

test('soft deleted reservations do not block new bookings for the same interval', function () {
    $manager = createTestManager();
    $customer = createTestCustomer();

    $category = ServiceCategory::query()->create(['name' => 'Room', 'slug' => 'room']);
    $type = ServiceType::query()->create(['service_category_id' => $category->id, 'name' => 'Meeting']);
    $service = Service::query()->create([
        'service_type_id' => $type->id,
        'name' => 'Soft delete test service',
        'code' => 'SFT-'.uniqid(),
        'base_price' => 90,
        'currency' => ServiceCurrency::Usd,
        'discount_percent' => 0,
        'is_active' => true,
    ]);

    $existing = Reservation::query()->create([
        'service_id' => $service->id,
        'customer_id' => $customer->id,
        'starts_at' => now()->addDay()->setTime(10, 0),
        'ends_at' => now()->addDay()->setTime(12, 0),
        'status' => ReservationStatus::Confirmed,
        'total_amount' => 90.00,
    ]);

    $existing->delete();

    $this->actingAs($manager)
        ->from(route('admin.reservations.create'))
        ->post(route('admin.reservations.store'), [
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'starts_at' => now()->addDay()->setTime(11, 0)->format('Y-m-d\TH:i'),
            'ends_at' => now()->addDay()->setTime(13, 0)->format('Y-m-d\TH:i'),
            'status' => ReservationStatus::Pending->value,
        ])
        ->assertRedirect(route('admin.reservations.index'));
});

test('cancelled reservations do not block new bookings for the same interval', function () {
    $manager = createTestManager();
    $customer = createTestCustomer();

    $category = ServiceCategory::query()->create(['name' => 'Room', 'slug' => 'room']);
    $type = ServiceType::query()->create(['service_category_id' => $category->id, 'name' => 'Meeting']);
    $service = Service::query()->create([
        'service_type_id' => $type->id,
        'name' => 'Cancelled test service',
        'code' => 'CNX-'.uniqid(),
        'base_price' => 70,
        'currency' => ServiceCurrency::Usd,
        'discount_percent' => 0,
        'is_active' => true,
    ]);

    Reservation::query()->create([
        'service_id' => $service->id,
        'customer_id' => $customer->id,
        'starts_at' => now()->addDay()->setTime(10, 0),
        'ends_at' => now()->addDay()->setTime(12, 0),
        'status' => ReservationStatus::Cancelled,
        'total_amount' => 70.00,
    ]);

    $this->actingAs($manager)
        ->from(route('admin.reservations.create'))
        ->post(route('admin.reservations.store'), [
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'starts_at' => now()->addDay()->setTime(11, 0)->format('Y-m-d\TH:i'),
            'ends_at' => now()->addDay()->setTime(13, 0)->format('Y-m-d\TH:i'),
            'status' => ReservationStatus::Pending->value,
        ])
        ->assertRedirect(route('admin.reservations.index'));
});
