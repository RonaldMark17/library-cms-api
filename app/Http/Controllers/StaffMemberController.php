<?php

namespace App\Http\Controllers;

use App\Models\StaffMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StaffMemberController extends Controller
{
    private function translateToTagalog($text) {
        $tr = new GoogleTranslate('tl'); // 'tl' = Tagalog
        return $tr->translate($text);
    }

    public function index() {
        $staff = StaffMember::where('is_active', true)->orderBy('order')->get();

        // Append full image URL
        $staff->each(function ($item) {
            if ($item->image_path) {
                $item->image_url = asset('storage/' . $item->image_path);
            }
        });

        return response()->json($staff);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => [
                'en' => $request->name,
                'tl' => $this->translateToTagalog($request->name),
            ],
            'role' => [
                'en' => $request->role,
                'tl' => $this->translateToTagalog($request->role),
            ],
            'email' => $request->email,
            'phone' => $request->phone,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        if ($request->has('bio')) {
            $data['bio'] = [
                'en' => $request->bio,
                'tl' => $this->translateToTagalog($request->bio),
            ];
        }

        $staff = StaffMember::create($data);

        // Append full image URL
        if ($staff->image_path) {
            $staff->image_url = asset('storage/' . $staff->image_path);
        }

        return response()->json($staff, 201);
    }

    public function update(Request $request, $id) {
        $staff = StaffMember::findOrFail($id);
        $data = [];

        if ($request->has('name')) {
            $data['name'] = [
                'en' => $request->name,
                'tl' => $this->translateToTagalog($request->name),
            ];
        }

        if ($request->has('role')) {
            $data['role'] = [
                'en' => $request->role,
                'tl' => $this->translateToTagalog($request->role),
            ];
        }

        if ($request->has('email')) $data['email'] = $request->email;
        if ($request->has('phone')) $data['phone'] = $request->phone;
        if ($request->has('order')) $data['order'] = $request->order;
        if ($request->has('is_active')) $data['is_active'] = $request->is_active;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($staff->image_path) {
                Storage::disk('public')->delete($staff->image_path);
            }
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        if ($request->has('bio')) {
            $data['bio'] = [
                'en' => $request->bio,
                'tl' => $this->translateToTagalog($request->bio),
            ];
        }

        $staff->update($data);

        // Append full image URL
        if ($staff->image_path) {
            $staff->image_url = asset('storage/' . $staff->image_path);
        }

        return response()->json($staff);
    }

    public function destroy($id) {
        $staff = StaffMember::findOrFail($id);
        $staff->delete();
        return response()->json(['message' => 'Staff member deleted successfully']);
    }

    public function restore($id) {
        $staff = StaffMember::withTrashed()->findOrFail($id);
        $staff->restore();
        return response()->json(['message' => 'Staff member restored successfully']);
    }
}
