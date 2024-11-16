<?php

namespace Mimachh\I18nertia;

use Illuminate\Support\ServiceProvider;

class I18nServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../Enums/Locales.php' => app_path('Enums/Locales.php'),
        ], 'i18nertia-enums');

        // le middleware
        $this->publishes([
            __DIR__ . '/../Middleware/InjectLocaldeData.php' => app_path('Http/Middleware/InjectLocaldeData.php'),
        ], 'i18nertia-middleware');

        $this->publishes([
            __DIR__ . '/./resources/js/Components/i18nertia' => resource_path('js/Components/mimachh/i18nertia')
        ], 'i18nertia-assets');
    }

    public function register()
    {
        //
    }
}
