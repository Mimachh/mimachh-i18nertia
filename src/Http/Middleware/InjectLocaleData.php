<?php

namespace Mimachh\I18nertia\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mimachh\I18nertia\Services\BrowserLanguageService;
use Symfony\Component\HttpFoundation\Response;

class InjectLocaleData
{
    // FIXME: possibilité d'utiliser le système de lang de laravel natif. En le chargeant ici.
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si la langue est définie dans la session
        $languageCode = session('locale', null);

        // TODO: mettre en cache la locale et donc la décacher avec le controller de changement de langue
        if (!$languageCode) {
            // Détecter la langue si elle n'est pas définie dans la session
            $browserLanguageService = new BrowserLanguageService();
            $languageCode = $browserLanguageService->detectLanguage($request);

            // Stocker la langue détectée dans la session
            session(['locale' => $languageCode]);
        }

        // Récupérer le nom de la route et composer le chemin du fichier JSON spécifique
        $routeName = $request->route()->getName();
        if($routeName == null){
            $routeData = null;
        } else {
            $localeFilePath = $this->getLocaleFilePath($languageCode, $routeName);
            $routeData = $this->loadJsonFile($localeFilePath);
        }
        
       

        // Charger les données spécifiques à la route ou les données globales si le fichier n'existe pas
        
        $globalData = $this->loadJsonFile(base_path("app/locales/{$languageCode}/global.json"));

        $fallbackData = $this->loadJsonFile(base_path("app/locales/{$languageCode}.json"));

        // Partager les données avec Inertia
        inertia()->share('localeData', [
            'data' => $routeData ?? $fallbackData ?? [],
            'global' => $globalData ?? $fallbackData ?? [],
            'languageCode' => $languageCode,
        ]);

        // Définir la locale de l'application
        App::setLocale($languageCode);

        return $next($request);
    }

    /**
     * Construit le chemin du fichier JSON en fonction de la langue et de la route.
     *
     * @param string $languageCode
     * @param string $routeName
     * @return string
     */
    private function getLocaleFilePath(string $languageCode, string $routeName): string
    {
        // dd($routeName);
        // Convertir le nom de la route en une arborescence de répertoires
        $path = str_replace('.', '/', $routeName);
        return base_path("app/locales/{$languageCode}/{$path}.json");
    }

    /**
     * Charge le fichier JSON et retourne son contenu sous forme de tableau.
     *
     * @param string $filePath
     * @return array|null
     */
    private function loadJsonFile(string $filePath): ?array
    {
        // TODO: mettre en cache les fichiers ?
        if (file_exists($filePath)) {
            return json_decode(file_get_contents($filePath), true);
        }
        return null;
    }
}
