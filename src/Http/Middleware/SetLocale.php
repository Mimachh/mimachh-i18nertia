<?php

namespace Mimachh\I18nertia\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // 1️⃣ Session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // 2️⃣ Locale depuis l’URL (LaravelLocalization)
        // 3️⃣ Fallback
        else {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
