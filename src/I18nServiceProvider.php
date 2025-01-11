<?php

namespace Mimachh\I18nertia;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Mimachh\I18nertia\Http\Middleware\LoadAllTranslations;
use Mimachh\I18nertia\Http\Middleware\SelectedTranslations;

class I18nServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */

    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/./routes/web.php');

        $this->publishes([
            __DIR__ . '/./Enums/Locales.php' => app_path('Enums/Locales.php'),
        ], 'i18nertia-enums');

        // le middleware
        $this->publishes([
            __DIR__ . '/../Middleware/InjectLocaldeData.php' => app_path('Http/Middleware/InjectLocaldeData.php'),
        ], 'i18nertia-middleware-json');

        $this->publishes([
            __DIR__ . '/../Middleware/SelectedTranslations.php' => app_path('Http/Middleware/SelectedTranslations.php'),
        ], 'i18nertia-middleware-selected');

        $this->publishes([
            __DIR__ . '/../Middleware/LoadAllTranslations.php' => app_path('Http/Middleware/LoadAllTranslations.php'),
        ], 'i18nertia-middleware-all');

        $this->publishes([
            __DIR__ . '/./resources/js/Components/i18nertia' => resource_path('js/Components/mimachh/i18nertia'),
            __DIR__ . '/./resources/js/hooks' => resource_path('js/hooks'),
            __DIR__ . '/./resources/js/types' => resource_path('js/types'),
        ], 'i18nertia-assets');


        $router->aliasMiddleware('translations', LoadAllTranslations::class);
        $router->aliasMiddleware('selected_translations', SelectedTranslations::class);
    }

    public function register()
    {
        //
    }
}
