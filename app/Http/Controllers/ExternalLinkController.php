<?php

namespace App\Http\Controllers;

use App\Models\ExternalLink;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ExternalLinkController extends Controller
{
    public function index(Request $request)
    {
        $links = ExternalLink::where('is_active', true)->orderBy('order')->get();

        // Check if Tagalog translation is requested
        $lang = $request->query('lang', 'en'); // default English
        if ($lang === 'tl') {
            $tr = new GoogleTranslate('tl'); // translate to Tagalog
            foreach ($links as $link) {
                $link->title = ['tl' => $tr->translate($link->title['en'])];
                if (!empty($link->description)) {
                    $link->description = ['tl' => $tr->translate($link->description['en'])];
                }
            }
        }

        return response()->json($links);
    }

    public function show($id)
    {
        $link = ExternalLink::findOrFail($id);
        return response()->json($link);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|string',
            'url' => 'required|url',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $link = ExternalLink::create($validated);
        return response()->json($link, 201);
    }

    public function update(Request $request, $id)
    {
        $link = ExternalLink::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|array',
            'url' => 'nullable|url',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $link->update($validated);
        return response()->json($link);
    }

    public function destroy($id)
    {
        $link = ExternalLink::findOrFail($id);
        $link->delete();
        return response()->json(['message' => 'Link deleted successfully']);
    }
}
