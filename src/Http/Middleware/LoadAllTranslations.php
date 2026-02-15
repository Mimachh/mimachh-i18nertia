<?php

namespace Mimachh\I18nertia\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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
        return Cache::rememberForever("translations_{$locale}", function () use ($locale) {
            $translations = [];
            $files = glob(lang_path("{$locale}/*.php"));
            foreach ($files as $file) {
                $key = basename($file, '.php');
                $translations[$key] = Lang::get($key);
            }
            return $translations;
        });
    }
}
