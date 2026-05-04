<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User; // إضافة موديل اليوزر
use Illuminate\Contracts\View\View;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomersController extends Controller
{
    public function index(): View
    {
        $customers = Customer::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('admin.customers.create');
    }

   public function store(StoreCustomerRequest $request): RedirectResponse
{
    $payload = $request->validated();

    try {
        DB::beginTransaction();
        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => Hash::make($payload['password']),
        ]);
        Customer::create([
            'user_id' => $user->id,
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
            'company_name' => $payload['company_name'] ?? null,
            'job_title' => $payload['job_title'] ?? null,
            'phone' => $payload['phone'] ?? null,
            'address' => $payload['address'] ?? null,
            'notes' => $payload['notes'] ?? null,
        ]);

        DB::commit();
        return redirect()->route('admin.customers.index')->with('status', __('Customer created.'));

    } catch (\Exception $e) {
        DB::rollBack();
        dd("The error is: " . $e->getMessage());
    }
}

    public function edit(Customer $customer): View
    {
        return view('admin.customers.edit', [
            'customer' => $customer,
        ]);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($customer, $data): void {
                if (isset($data['name'])) {
                    $customer->name = $data['name'];
                }

                if (isset($data['email'])) {
                    $customer->email = $data['email'];
                }

                if (! empty($data['password'])) {
                    $customer->password = $data['password'];
                }

                foreach (['company_name', 'job_title', 'phone', 'address', 'notes'] as $field) {
                    if (array_key_exists($field, $data)) {
                        $customer->{$field} = $data[$field];
                    }
                }

                $customer->save();
            });
        } catch (UniqueConstraintViolationException $e) {
            if (
                in_array('email', $e->columns, true)
                || ($e->index !== null && str_contains($e->index, 'email'))
                || str_contains($e->getMessage(), 'customers_email_unique')
            ) {
                throw ValidationException::withMessages([
                    'email' => __('This email is already registered.'),
                ]);
            }

            throw $e;
        }

        return redirect()->route('admin.customers.index')->with('status', __('Customer updated.'));
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('status', __('Customer removed.'));
    }
}
