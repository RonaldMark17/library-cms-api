<?php

namespace App\Http\Controllers;

use App\Models\GuestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GuestSubscriberController extends Controller
{
    // Subscribe a new email
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:guest_subscribers'
        ]);

        $token = Str::random(64);
        $subscriber = GuestSubscriber::create([
            'email' => $validated['email'],
            'verification_token' => $token
        ]);

        $verificationUrl = env('FRONTEND_URL') . "/verify-subscription?token={$token}";

        try {
            Mail::raw(
                "Please verify your subscription by clicking this link: {$verificationUrl}",
                function($message) use ($validated) {
                    $message->to($validated['email'])
                        ->subject('Verify Your Subscription');
                }
            );
        } catch (\Exception $e) {
            // Continue even if email fails
        }

        return response()->json([
            'message' => 'Subscription successful. Please check your email to verify.'
        ], 201);
    }

    // Verify email using token
    public function verify(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string'
        ]);

        $subscriber = GuestSubscriber::where('verification_token', $validated['token'])->first();

        if (!$subscriber) {
            return response()->json(['message' => 'Invalid verification token'], 404);
        }

        $subscriber->update([
            'verified_at' => now(),
            'verification_token' => null
        ]);

        return response()->json(['message' => 'Email verified successfully']);
    }

    // Unsubscribe an email
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $subscriber = GuestSubscriber::where('email', $validated['email'])->first();

        if (!$subscriber) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $subscriber->update(['is_active' => false]);

        return response()->json(['message' => 'Unsubscribed successfully']);
    }

    // List all active subscribers (verified and unverified)
    public function index()
    {
        $subscribers = GuestSubscriber::where('is_active', true)
            ->paginate(20); // Include all active subscribers
        return response()->json($subscribers);
    }
}
