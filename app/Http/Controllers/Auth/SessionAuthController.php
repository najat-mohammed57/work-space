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

        return redirect()->intended(route('admin.dashboard'))->with('status', __('Signed in successfully.'));
    }

    public function destroy(Request $request): Response|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('login');
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
}
