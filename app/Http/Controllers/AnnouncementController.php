<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\GuestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::latest('published_at')->paginate(10);

        $announcements->getCollection()->transform(function ($a) {
            $a->image_url = $a->image_path ? asset("storage/" . $a->image_path) : null;
            return $a;
        });

        return response()->json($announcements);
    }

    public function show($id)
    {
        $a = Announcement::findOrFail($id);
        $a->image_url = $a->image_path ? asset("storage/" . $a->image_path) : null;
        return response()->json($a);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'priority' => 'nullable|in:low,medium,high',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean'
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
            // ignore email errors
        }

        return response()->json($announcement, 201);
    }

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
            // Generate unsubscribe token if missing
            if (!$subscriber->unsubscribe_token) {
                $subscriber->unsubscribe_token = Str::random(64);
                $subscriber->save();
            }

            $unsubscribeUrl = env('FRONTEND_URL') . "/unsubscribe?token=" . $subscriber->unsubscribe_token;

            $messageBody = "New announcement: {$announcement->title['en']}\n\n";
            $messageBody .= "{$announcement->content['en']}\n\n";
            $messageBody .= "If you no longer wish to receive these notifications, you can unsubscribe here: {$unsubscribeUrl}";

            try {
                Mail::raw($messageBody, function ($message) use ($subscriber) {
                    $message->to($subscriber->email)
                        ->subject('New Library Announcement');
                });
            } catch (\Exception $e) {
                // ignore email errors
            }
        }
    }
}
