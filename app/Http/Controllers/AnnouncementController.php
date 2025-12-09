<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\GuestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('creator');

        if (!$request->user() || !$request->user()->isLibrarian()) {
            $query->active();
        }

        $announcements = $query->latest('published_at')->paginate(10);
        return response()->json($announcements);
    }

    public function show($id)
    {
        $announcement = Announcement::with('creator')->findOrFail($id);
        return response()->json($announcement);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title.en' => 'required|string',
            'title.tl' => 'nullable|string',
            'content.en' => 'required|string',
            'content.tl' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'priority' => 'nullable|in:low,medium,high',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'title' => [
                'en' => $request->input('title.en'),
                'tl' => $request->input('title.tl') ?? $request->input('title.en'),
            ],
            'content' => [
                'en' => $request->input('content.en'),
                'tl' => $request->input('content.tl') ?? $request->input('content.en'),
            ],
            'priority' => $request->priority ?? 'medium',
            'published_at' => $request->published_at ?? now(),
            'expires_at' => $request->expires_at,
            'is_active' => $request->is_active ?? true,
            'created_by' => $request->user()->id,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);

        // Notify subscribers
        try {
            $this->notifySubscribers($announcement);
        } catch (\Exception $e) {
            // Continue even if notification fails
        }

        return response()->json($announcement, 201);
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $data = [];

        if ($request->has('title.en')) {
            $data['title'] = [
                'en' => $request->input('title.en'),
                'tl' => $request->input('title.tl') ?? $request->input('title.en'),
            ];
        }

        if ($request->has('content.en')) {
            $data['content'] = [
                'en' => $request->input('content.en'),
                'tl' => $request->input('content.tl') ?? $request->input('content.en'),
            ];
        }

        if ($request->has('priority')) $data['priority'] = $request->priority;
        if ($request->has('published_at')) $data['published_at'] = $request->published_at;
        if ($request->has('expires_at')) $data['expires_at'] = $request->expires_at;
        if ($request->has('is_active')) $data['is_active'] = $request->is_active;

        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);
        return response()->json($announcement);
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted successfully']);
    }

    public function restore($id)
    {
        $announcement = Announcement::withTrashed()->findOrFail($id);
        $announcement->restore();
        return response()->json(['message' => 'Announcement restored successfully']);
    }

    private function notifySubscribers($announcement)
    {
        $subscribers = GuestSubscriber::where('is_active', true)
            ->whereNotNull('verified_at')
            ->get();

        foreach ($subscribers as $subscriber) {
            Mail::raw(
                "New announcement: {$announcement->title['en']}\n\n{$announcement->content['en']}",
                function($message) use ($subscriber) {
                    $message->to($subscriber->email)
                        ->subject('New Library Announcement');
                }
            );
        }
    }
}
