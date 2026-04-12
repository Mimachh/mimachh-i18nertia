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
use Mimachh\LaravelCommon\Helpers\ToolboxHelper;
use Mimachh\LaravelCommon\Support\TranslationRegistry;

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

        $isAdmin = $request->route()?->getPrefix() === 'admin';

        $translations = array_merge(
            ToolboxHelper::getCachedTranslations($languageCode),                  
            TranslationRegistry::resolve($isAdmin ? 'back' : 'front'), 
            TranslationRegistry::resolve('global')
        );

        inertia()->share('translations', [
            'translations' => $translations,
            'languageCode' => $languageCode,
        ]);

        return $next($request);
    }

}
