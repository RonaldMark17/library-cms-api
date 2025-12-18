<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\GuestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;
use App\Mail\NewAnnouncement;

class AnnouncementController extends Controller
{
    /**
     * List announcements with pagination
     */
    public function index(Request $request)
    {
        $announcements = Announcement::latest('published_at')->paginate(10);

        $announcements->getCollection()->transform(function ($a) {
            $a->image_url = $a->image_path ? asset("storage/" . $a->image_path) : null;
            return $a;
        });

        return response()->json($announcements);
    }

    /**
     * Create a new announcement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'priority' => 'nullable|in:low,medium,high',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
        ]);

        $tr = new GoogleTranslate('tl');

        $data = [
            'title' => [
                'en' => $request->title,
                'tl' => $tr->translate($request->title),
            ],
            'content' => [
                'en' => $request->content,
                'tl' => $tr->translate($request->content),
            ],
            'priority' => $request->priority ?? 'medium',
            'published_at' => $request->published_at ?? now(),
            'expires_at' => $request->expires_at,
            'is_active' => true,
            'created_by' => $request->user()->id,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);

        // Send email notifications to subscribers
        $this->notifySubscribers($announcement);

        return response()->json($announcement, 201);
    }

    /**
     * Update an existing announcement
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $tr = new GoogleTranslate('tl');
        $data = [];

        if ($request->has('title')) {
            $data['title'] = [
                'en' => $request->title,
                'tl' => $tr->translate($request->title),
            ];
        }

        if ($request->has('content')) {
            $data['content'] = [
                'en' => $request->content,
                'tl' => $tr->translate($request->content),
            ];
        }

        if ($request->has('priority')) $data['priority'] = $request->priority;
        if ($request->has('published_at')) $data['published_at'] = $request->published_at;
        if ($request->has('expires_at')) $data['expires_at'] = $request->expires_at;

        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);

        return response()->json($announcement);
    }

    /**
     * Delete an announcement
     */
    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return response()->json(['message' => 'Announcement deleted successfully']);
    }

    /**
     * Show a single announcement
     */
    public function show($id)
    {
        $announcement = Announcement::with('creator')->find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $announcement->image_url = $announcement->image_path ? asset("storage/" . $announcement->image_path) : null;

        return response()->json($announcement);
    }

    /**
     * Notify active verified subscribers about a new announcement
     */
    public function notifySubscribers(Announcement $announcement)
    {
        // Prevent duplicate notifications
        if ($announcement->notified_at) return;

        // Skip future announcements
        if ($announcement->published_at && $announcement->published_at->isFuture()) return;

        // Skip expired announcements
        if ($announcement->expires_at && $announcement->expires_at->isPast()) return;

        $subscribers = GuestSubscriber::where('is_active', true)
            ->whereNotNull('verified_at')
            ->get();

        foreach ($subscribers as $subscriber) {
            if (!$subscriber->unsubscribe_token) {
                $subscriber->update([
                    'unsubscribe_token' => Str::random(64)
                ]);
            }

            $unsubscribeUrl = env('FRONTEND_URL') . "/unsubscribe?token={$subscriber->unsubscribe_token}";

            try {
                Mail::to($subscriber->email)
                    ->send(new \App\Mail\NewAnnouncement($announcement, $unsubscribeUrl));
            } catch (\Exception $e) {
                logger()->error('Announcement email failed: ' . $e->getMessage());
            }
        }

        $announcement->update(['notified_at' => now()]);
    }
}
