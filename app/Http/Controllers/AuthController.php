<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:admin,librarian,staff'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'staff'
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ], 422);
        }

        // Block disabled users
        if ($user->disabled) {
            return response()->json([
                'message' => 'Your account is disabled. Contact admin.'
            ], 403);
        }

        // Handle 2FA
        if ($user->two_factor_enabled) {
            $code = rand(100000, 999999);
            Cache::put("2fa_{$user->id}", $code, now()->addMinutes(10));

            try {
                Mail::raw("Your 2FA code is: $code", function ($message) use ($user) {
                    $message->to($user->email)->subject('Two-Factor Authentication Code');
                });
            } catch (\Exception $e) {
                // Continue without 2FA if email fails
            }

            return response()->json([
                'message' => '2FA code sent to your email',
                'requires_2fa' => true,
                'user_id' => $user->id
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // Verify 2FA
    public function verify2FA(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string'
        ]);

        $cachedCode = Cache::get("2fa_{$validated['user_id']}");

        if (!$cachedCode || $cachedCode != $validated['code']) {
            return response()->json(['message' => 'Invalid 2FA code'], 401);
        }

        Cache::forget("2fa_{$validated['user_id']}");
        $user = User::find($validated['user_id']);

        if ($user->disabled) {
            return response()->json([
                'message' => 'Your account is disabled. Contact admin.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => '2FA verification successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // Enable 2FA for authenticated user
    public function enable2FA(Request $request)
    {
        $user = $request->user();
        $user->update(['two_factor_enabled' => true]);

        return response()->json([
            'message' => '2FA enabled successfully',
            'two_factor_enabled' => $user->two_factor_enabled
        ]);
    }

    // Disable 2FA for authenticated user
    public function disable2FA(Request $request)
    {
        $user = $request->user();
        $user->update(['two_factor_enabled' => false]);

        return response()->json([
            'message' => '2FA disabled successfully',
            'two_factor_enabled' => $user->two_factor_enabled
        ]);
    }


    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get authenticated user
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
