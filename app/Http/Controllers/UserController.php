<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users (public)
    public function index()
    {
        return response()->json(User::orderBy('created_at', 'desc')->get());
    }

    // Show single user (public)
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }

        return response()->json($user);
    }

    // Create a new user (protected)
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6|confirmed",
            "role" => "required|string|in:admin,librarian,staff",
            "phone" => "nullable|string|max:20",
            "bio" => "nullable|string",
            "image" => "nullable|image|max:2048"
        ]);

        $validated["password"] = Hash::make($validated["password"]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $validated['image_path'] = $path;
        }

        if (isset($validated['bio'])) {
            $validated['bio'] = ['en' => $validated['bio']];
        }

        $user = User::create($validated);

        return response()->json([
            "message" => "User created successfully",
            "user" => $user
        ], 201);
    }

    // Update user (protected)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$request->user()->isAdmin() && $request->has("role")) {
            return response()->json(["message" => "Unauthorized"], 403);
        }

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => ["required", "email", Rule::unique("users")->ignore($user->id)],
            "role" => "nullable|string|in:admin,librarian,staff",
            "password" => "nullable|string|min:6|confirmed",
            "phone" => "nullable|string|max:20",
            "bio" => "nullable|string",
            "image" => "nullable|image|max:2048"
        ]);

        if (!empty($validated["password"])) {
            $validated["password"] = Hash::make($validated["password"]);
        } else {
            unset($validated["password"]);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $validated['image_path'] = $path;
        }

        if (isset($validated['bio'])) {
            $validated['bio'] = ['en' => $validated['bio']];
        }

        $user->update($validated);

        return response()->json([
            "message" => "User updated successfully",
            "user" => $user
        ]);
    }

    // Toggle disable/enable user (protected)
    public function toggleDisable(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$request->user()->isAdmin()) {
            return response()->json(["message" => "Unauthorized"], 403);
        }

        if ($request->user()->id === $user->id) {
            return response()->json(["message" => "You cannot disable yourself"], 400);
        }

        $user->disabled = !$user->disabled;
        $user->save();

        return response()->json([
            "message" => $user->disabled ? "User disabled" : "User enabled",
            "user" => $user
        ]);
    }

    // Delete user (admin only)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(["message" => "User deleted successfully"]);
    }
}
