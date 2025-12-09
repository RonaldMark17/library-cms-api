<?php
namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function translate(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'target_lang' => 'required|string',
            'source_lang' => 'required|string'
        ]);

        $translated = $this->translationService->translate(
            $validated['text'],
            $validated['target_lang'],
            $validated['source_lang']
        );

        return response()->json([
            'original_text' => $validated['text'],
            'translated_text' => $translated,
            'source_lang' => $validated['source_lang'],
            'target_lang' => $validated['target_lang']
        ]);
    }
}