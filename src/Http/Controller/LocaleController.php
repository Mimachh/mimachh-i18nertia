<?php

namespace Mimachh\I18nertia\Http\Controller;

use App\Http\Controllers\Controller;
use Mimachh\I18nertia\Http\Requests\ChangeLocaleRequest;

class LocaleController extends Controller
{
    public function __invoke(ChangeLocaleRequest $request)
    {
        $data = $request->validated();

        $lang = $data['locale'];
        if (!\in_array($lang, config('app.locales'))) {
            $lang = config('app.fallback_locale');
        }

        if ($lang) {
            session(['locale' => $lang]);
            app()->setLocale($lang);
            return redirect()->back();
        }
    }
}
