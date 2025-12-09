<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setSource('en');
        $this->translator->setTarget('tl');
    }

    public function translateToTagalog($text)
    {
        try {
            return $this->translator->translate($text);
        } catch (\Exception $e) {
            return ""; // fallback
        }
    }
}
