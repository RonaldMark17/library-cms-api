<?php

namespace App\Http\Controllers;

use App\Models\ContentSection;
use Illuminate\Http\Request;
use App\Services\TranslationService;

class ContentSectionController extends Controller
{
    public function index()
    {
        $sections = ContentSection::where('is_active', true)
            ->orderBy('order')
            ->get();
        return response()->json($sections);
    }

    public function show($key)
    {
        $section = ContentSection::where('key', $key)
            ->orWhere('id', $key)
            ->firstOrFail();
        return response()->json($section);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:content_sections',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.tl' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $section = ContentSection::create($validated);
        return response()->json($section, 201);
    }

    public function update(Request $request, $id)
    {
        $section = ContentSection::findOrFail($id);

        $translationService = new TranslationService();
        $tagalog = $translationService->translateToTagalog($request->content['en']);

        $section->content = [
            "en" => $request->content['en'],
            "tl" => $tagalog,
        ];

        $section->save();

        return response()->json([
            "message" => "Content updated",
            "section" => $section
        ]);
    }

    public function destroy($id)
    {
        $section = ContentSection::findOrFail($id);
        $section->delete();
        return response()->json(['message' => 'Section deleted successfully']);
    }

    public function restore($id)
    {
        $section = ContentSection::withTrashed()->findOrFail($id);
        $section->restore();
        return response()->json(['message' => 'Section restored successfully']);
    }
}
