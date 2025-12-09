<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_active', true)->get();
        return response()->json($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:pages',
            'title' => 'required|array',
            'title.en' => 'required|string',
            'title.tl' => 'nullable|string',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.tl' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $page = Page::create($validated);
        return response()->json($page, 201);
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'slug' => 'nullable|string|unique:pages,slug,' . $id,
            'title' => 'nullable|array',
            'content' => 'nullable|array',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        if (isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $page->update($validated);
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Page deleted successfully']);
    }

    public function restore($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $page->restore();
        return response()->json(['message' => 'Page restored successfully']);
    }
}