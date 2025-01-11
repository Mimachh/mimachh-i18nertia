<?php

namespace Mimachh\I18nertia\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Mimachh\I18nertia\Services\BrowserLanguageService;
use Symfony\Component\HttpFoundation\Response;

class SelectedTranslations
{
    public function handle(Request $request, Closure $next, string $files): Response
    {
        $languageCode = session('locale', null);

        if (!$languageCode) {
            $browserLanguageService = new BrowserLanguageService();
            $languageCode = $browserLanguageService->detectLanguage($request);
            session(['locale' => $languageCode]);
        }

        App::setLocale($languageCode);

        // Charger les traductions de Laravel
        $translationFiles = explode(',', $files);
        $translations = $this->loadTranslations($languageCode, $translationFiles);

        inertia()->share('localeDataBase', [
            'translations' => $translations,
            'languageCode' => $languageCode,
        ]);

        return $next($request);
    }

    private function loadTranslations(string $locale, array $files): array
    {
        App::setLocale($locale);
        $translations = [];

        foreach ($files as $file) {
            $translations[$file] = Lang::get($file);
        }

        return $translations;
    }
}
