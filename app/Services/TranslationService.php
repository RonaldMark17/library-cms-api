<?php
namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;



class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate($text, $targetLang = 'tl', $sourceLang = 'en')
    {
        try {
            $this->translator->setSource($sourceLang);
            $this->translator->setTarget($targetLang);
            return $this->translator->translate($text);
        } catch (\Exception $e) {
            Log::error('Translation error: ' . $e->getMessage());
            return $text;
        }
    }

    public function translateArray($data, $targetLang = 'tl', $sourceLang = 'en')
    {
        $translated = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $translated[$key] = $this->translate($value, $targetLang, $sourceLang);
            } else {
                $translated[$key] = $value;
            }
        }
        return $translated;
    }

    public function autoTranslateContent($content, $sourceLang = 'en')
    {
        $languages = ['tl'];
        $translations = [$sourceLang => $content];

        foreach ($languages as $lang) {
            $translations[$lang] = $this->translate($content, $lang, $sourceLang);
        }

        return $translations;
    }
}
