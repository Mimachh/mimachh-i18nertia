<?php

namespace Mimachh\I18nertia\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mimachh\I18nertia\Services\BrowserLanguageService;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Middleware;
use Illuminate\Support\Facades\Lang;

class LoadAllTranslations extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $languageCode = session('locale', null);

        if (!$languageCode) {
            $browserLanguageService = new BrowserLanguageService();
            $languageCode = $browserLanguageService->detectLanguage($request);
            session(['locale' => $languageCode]);
        }

        App::setLocale($languageCode);
        $translations = $this->loadTranslations($languageCode);
        inertia()->share('translations', [
            'translations' => $translations,
            'languageCode' => $languageCode,
        ]);

        return $next($request);
    }

    private function loadTranslations(string $locale): array
    {
        App::setLocale($locale);
        $translations = [];
        $files = glob(app_path("lang/{$locale}/*.php"));
    
        foreach ($files as $file) {
            $translations[$file] = Lang::get($file);
        }
    
        return $translations;
    }
}
