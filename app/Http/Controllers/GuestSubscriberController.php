<?php

namespace App\Http\Controllers;

use App\Models\GuestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifySubscription;

class GuestSubscriberController extends Controller
{
    /**
     * Subscribe a new guest or reactivate an existing one.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $subscriber = GuestSubscriber::where('email', $email)->first();
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');

        // Generate tokens
        $token = Str::random(64);
        $unsubscribeToken = Str::random(64);

        if ($subscriber) {
            if ($subscriber->is_active && $subscriber->verified_at) {
                return response()->json([
                    'message' => 'You are already subscribed.'
                ], 200);
            }

            // Reactivate subscriber safely
            $subscriber->update([
                'verification_token' => $token,
                'unsubscribe_token' => $unsubscribeToken,
                'is_active' => true,
                'verified_at' => null
            ]);

            $verificationUrl = $frontendUrl . "/verify-subscription?token={$token}";

            try {
                Mail::to($email)->send(new VerifySubscription($verificationUrl, $email));
            } catch (\Exception $e) {
                \Log::error("Mail sending failed: " . $e->getMessage());
            }

            return response()->json([
                'message' => 'Subscription reactivated. Please check your email to verify.'
            ], 200);
        }

        // New subscriber
        $subscriber = GuestSubscriber::create([
            'email' => $email,
            'verification_token' => $token,
            'unsubscribe_token' => $unsubscribeToken,
            'is_active' => true
        ]);

        $verificationUrl = $frontendUrl . "/verify-subscription?token={$token}";

        try {
            Mail::to($email)->send(new VerifySubscription($verificationUrl, $email));
        } catch (\Exception $e) {
            \Log::error("Mail sending failed: " . $e->getMessage());
        }

        \Log::info("New subscriber created: {$email}, token: {$token}");

        return response()->json([
            'message' => 'Subscription successful. Please check your email to verify.'
        ], 201);
    }

    /**
     * Verify subscriber email. Idempotent.
     */
    public function verify(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');

        if (!$token) {
            return response()->json(['message' => 'Verification token is required'], 422);
        }

        $subscriber = GuestSubscriber::where('verification_token', $token)->first();

        if (!$subscriber) {
            return response()->json(['message' => 'Invalid or expired verification token'], 404);
        }

        // Already verified
        if ($subscriber->verified_at) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Mark as verified
        $subscriber->update([
            'verified_at' => now(),
            'verification_token' => null // clear token to prevent multiple clicks
        ]);

        return response()->json(['message' => 'Email verified successfully'], 200);
    }

    /**
     * Unsubscribe via token or email. Idempotent.
     */
    public function unsubscribe(Request $request)
    {
        $token = $request->input('token') ?? null;
        $email = $request->input('email') ?? null;

        if (!$token && !$email) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token or email is required'
            ], 422);
        }

        $subscriber = $token
            ? GuestSubscriber::where('unsubscribe_token', $token)->first()
            : GuestSubscriber::where('email', $email)->first();

        if (!$subscriber) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscriber not found'
            ], 404);
        }

        if (!$subscriber->is_active) {
            return response()->json([
                'status' => 'info',
                'message' => 'You are already unsubscribed'
            ], 200);
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribe_token' => null
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully unsubscribed'
        ], 200);
    }

    /**
     * Unsubscribe view for frontend. Idempotent.
     */
    public function unsubscribeView(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return view('unsubscribe', [
                'status' => 'error',
                'message' => 'Invalid unsubscribe link.'
            ]);
        }

        $subscriber = GuestSubscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return view('unsubscribe', [
                'status' => 'info',
                'message' => 'Subscriber not found or already unsubscribed.'
            ]);
        }

        if (!$subscriber->is_active) {
            return view('unsubscribe', [
                'status' => 'info',
                'message' => 'You are already unsubscribed.'
            ]);
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribe_token' => null
        ]);

        return view('unsubscribe', [
            'status' => 'success',
            'message' => 'You have successfully unsubscribed from notifications.'
        ]);
    }

    /**
     * List active subscribers.
     */
    public function index()
    {
        $subscribers = GuestSubscriber::where('is_active', true)->paginate(20);
        return response()->json($subscribers);
    }
}
