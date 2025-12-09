<?php

namespace App\Http\Controllers;

use App\Models\StaffMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffMemberController extends Controller
{
    public function index()
    {
        $staff = StaffMember::where('is_active', true)
            ->orderBy('order')
            ->get();
        return response()->json($staff);
    }

    public function show($id)
    {
        $staff = StaffMember::findOrFail($id);
        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.tl' => 'nullable|string',
            'role.en' => 'required|string',
            'role.tl' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'bio.en' => 'nullable|string',
            'bio.tl' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'name' => [
                'en' => $request->input('name.en'),
                'tl' => $request->input('name.tl') ?? $request->input('name.en'),
            ],
            'role' => [
                'en' => $request->input('role.en'),
                'tl' => $request->input('role.tl') ?? $request->input('role.en'),
            ],
            'email' => $request->email,
            'phone' => $request->phone,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        if ($request->has('bio.en')) {
            $data['bio'] = [
                'en' => $request->input('bio.en'),
                'tl' => $request->input('bio.tl') ?? $request->input('bio.en'),
            ];
        }

        $staff = StaffMember::create($data);
        return response()->json($staff, 201);
    }

    public function update(Request $request, $id)
    {
        $staff = StaffMember::findOrFail($id);

        $data = [];

        if ($request->has('name.en')) {
            $data['name'] = [
                'en' => $request->input('name.en'),
                'tl' => $request->input('name.tl') ?? $request->input('name.en'),
            ];
        }

        if ($request->has('role.en')) {
            $data['role'] = [
                'en' => $request->input('role.en'),
                'tl' => $request->input('role.tl') ?? $request->input('role.en'),
            ];
        }

        if ($request->has('email')) $data['email'] = $request->email;
        if ($request->has('phone')) $data['phone'] = $request->phone;
        if ($request->has('order')) $data['order'] = $request->order;
        if ($request->has('is_active')) $data['is_active'] = $request->is_active;

        if ($request->hasFile('image')) {
            if ($staff->image_path) {
                Storage::disk('public')->delete($staff->image_path);
            }
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        if ($request->has('bio.en')) {
            $data['bio'] = [
                'en' => $request->input('bio.en'),
                'tl' => $request->input('bio.tl') ?? $request->input('bio.en'),
            ];
        }

        $staff->update($data);
        return response()->json($staff);
    }

    public function destroy($id)
    {
        $staff = StaffMember::findOrFail($id);
        $staff->delete();
        return response()->json(['message' => 'Staff member deleted successfully']);
    }

    public function restore($id)
    {
        $staff = StaffMember::withTrashed()->findOrFail($id);
        $staff->restore();
        return response()->json(['message' => 'Staff member restored successfully']);
    }
}