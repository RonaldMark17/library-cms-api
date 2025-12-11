<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        // Only show active items for frontend navigation
        $menuItems = MenuItem::with('children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        return response()->json($menuItems);
    }

    public function show($id)
    {
        $menuItem = MenuItem::with('children')->findOrFail($id);
        return response()->json($menuItem);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:menu_items,id',
            'label' => 'required|array',
            'label.en' => 'required|string',
            'label.tl' => 'nullable|string',
            'url' => 'nullable|string',
            'type' => 'required|in:internal,external,page',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $menuItem = MenuItem::create($validated);
        return response()->json($menuItem, 201);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $validated = $request->validate([
            'parent_id' => 'nullable|exists:menu_items,id',
            'label' => 'nullable|array',
            'url' => 'nullable|string',
            'type' => 'nullable|in:internal,external,page',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $menuItem->update($validated);
        return response()->json($menuItem);
    }

    public function toggleActive($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['is_active' => !$menuItem->is_active]);
        $status = $menuItem->is_active ? 'unhidden' : 'hidden';
        return response()->json(['message' => "Menu item {$status} successfully", 'menuItem' => $menuItem]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.order' => 'required|integer'
        ]);

        foreach ($validated['items'] as $item) {
            MenuItem::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Menu reordered successfully']);
    }
}
