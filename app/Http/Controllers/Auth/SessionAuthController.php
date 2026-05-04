<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class SessionAuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

   public function store(LoginRequest $request): JsonResponse|RedirectResponse
{
    if (! Auth::attempt($request->validated(), remember: $request->boolean('remember'))) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('Invalid credentials.'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return back()->withErrors([
            'email' => __('Invalid credentials.'),
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    if ($request->expectsJson()) {
        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'data' => $this->userPayload($user),
        ]);
    }

    if (Auth::user()->email === 'admin@admin.com') {
        return redirect()->intended(route('admin.dashboard'))->with('status', __('Signed in successfully.'));
    }

    return redirect()->route('home')->with('status', __('Signed in successfully.'));
}
public function destroy(Request $request): Response|RedirectResponse
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($request->expectsJson()) {
        return response()->noContent();
    }

    return redirect()->route('home')->with('status', 'Logged out successfully');
}

    /**
     * @return array<string, mixed>
     */
    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
    public function register()
    {
    return view('auth.register');
}
public function storeRegister(Request $request)
{
    $attributes = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $attributes['name'],
        'email' => $attributes['email'],
        'password' => Hash::make($attributes['password']),
    ]);
    Customer::create([
        'user_id' => $user->id,
        'name'    => $user->name,
        'email'   => $user->email,
        'password'=> $attributes['password'],
    ]);

    auth()->login($user);

    return redirect()->route('home')->with('success', 'Welcome to WorkSpace!');
}

}
