<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\StaffMember;
use App\Models\Page;
use App\Models\ContentSection;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2',
            'language' => 'nullable|string|in:en,tl'
        ]);

        $query = $validated['query'];
        $language = $validated['language'] ?? 'en';

        // Search Announcements
        $announcements = Announcement::where('is_active', true)
            ->where(function($q) use ($query, $language) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(content, '$.{$language}')) LIKE ?", ["%{$query}%"]);
            })
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        // Search Staff Members
        $staff = StaffMember::where('is_active', true)
            ->where(function($q) use ($query, $language) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(role, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->orderBy('order')
            ->limit(10)
            ->get();

        // Search Pages
        $pages = Page::where('is_active', true)
            ->where(function($q) use ($query, $language) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(content, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhere('slug', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        // Search Content Sections
        $contentSections = ContentSection::where('is_active', true)
            ->where(function($q) use ($query, $language) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(content, '$.{$language}')) LIKE ?", ["%{$query}%"])
                    ->orWhere('key', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get();

        return response()->json([
            'query' => $query,
            'language' => $language,
            'results' => [
                'announcements' => $announcements,
                'staff' => $staff,
                'pages' => $pages,
                'content_sections' => $contentSections,
            ],
            'total' => $announcements->count() + $staff->count() + $pages->count() + $contentSections->count()
        ]);
    }
}