<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        try {
            DB::transaction(function () use ($user, $request): void {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            });
        } catch (UniqueConstraintViolationException $e) {
            throw ValidationException::withMessages([
                'email' => __('This email is already registered.'),
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function passwordEdit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        try {
            DB::transaction(function () use ($request): void {
                Auth::user()->update([
                    'password' => Hash::make($request->new_password)
                ]);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while updating password.']);
        }

        return back()->with('success', 'Password changed successfully!');
    }

    public function createAdmin()
    {
        return view('admin.profile.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            DB::transaction(function () use ($request): void {
                \App\Models\User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            });
        } catch (UniqueConstraintViolationException $e) {
            throw ValidationException::withMessages([
                'email' => __('This email is already registered.'),
            ]);
        }

        return back()->with('success', 'Admin created successfully!');
    }
}
