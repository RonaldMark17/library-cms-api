<?php

namespace App\Http\Controllers;

use App\Models\ExternalLink;
use Illuminate\Http\Request;

class ExternalLinkController extends Controller
{
    public function index()
    {
        $links = ExternalLink::where('is_active', true)->orderBy('order')->get();
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
            'title.tl' => 'nullable|string',
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

    public function restore($id)
    {
        $link = ExternalLink::withTrashed()->findOrFail($id);
        $link->restore();
        return response()->json(['message' => 'Link restored successfully']);
    }
}