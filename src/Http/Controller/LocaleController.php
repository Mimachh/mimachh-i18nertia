<?php

namespace Mimachh\I18nertia\Http\Controller;

use App\Http\Controllers\Controller;
use Mimachh\I18nertia\Http\Requests\ChangeLocaleRequest;

class LocaleController extends Controller
{
    public function __invoke(ChangeLocaleRequest $request)
    {
       $data = $request->validated();

       if($data) {
        session(['locale' => $data['locale']]);
        return redirect()->back(303);
       }

    }
}
