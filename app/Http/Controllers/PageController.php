<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

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
            'title' => 'required|string',
            'content' => 'required|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        // Auto-translate English to Tagalog
        $tr = new GoogleTranslate('tl');
        $title_tl = $tr->translate($validated['title']);
        $content_tl = $tr->translate($validated['content']);

        $page = Page::create([
            'slug' => $validated['slug'],
            'title' => ['en' => $validated['title'], 'tl' => $title_tl],
            'content' => ['en' => $validated['content'], 'tl' => $content_tl],
            'meta_description' => $validated['meta_description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json($page, 201);
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'slug' => 'nullable|string|unique:pages,slug,' . $id,
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        if (isset($validated['slug'])) {
            $page->slug = Str::slug($validated['slug']);
        }

        $tr = new GoogleTranslate('tl');
        if (isset($validated['title'])) {
            $page->title = [
                'en' => $validated['title'],
                'tl' => $tr->translate($validated['title'])
            ];
        }

        if (isset($validated['content'])) {
            $page->content = [
                'en' => $validated['content'],
                'tl' => $tr->translate($validated['content'])
            ];
        }

        if (isset($validated['meta_description'])) {
            $page->meta_description = $validated['meta_description'];
        }

        if (isset($validated['is_active'])) {
            $page->is_active = $validated['is_active'];
        }

        $page->save();

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
