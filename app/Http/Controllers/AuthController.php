<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login a User
     *
     * @param  LoginRequest  $request
     * @throws ValidationException
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = Auth::attempt($request->validated());

        $request->authenticate($token);

        $user = Auth::user();

        return response()->json([
                'status' => config('auth.statuses.success'),
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    }

    /**
     * Register a User.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        $token = Auth::login($user);

        return response()->json([
            'status' => config('auth.statuses.success'),
            'message' => __('User created successfully'),
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * Logout a User.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status' => config('auth.statuses.success'),
            'message' => __('Successfully logged out'),
        ]);
    }

    /**
     * Refresh a User.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => config('auth.statuses.success'),
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
