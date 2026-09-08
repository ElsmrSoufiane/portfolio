<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    private const AVAILABLE_LOCALES = ['en', 'fr', 'ar'];

    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, self::AVAILABLE_LOCALES, true)) {
            abort(404);
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        $back = $request->headers->get('referer');

        return $back && str_starts_with($back, $request->getSchemeAndHttpHost())
            ? redirect($back)
            : redirect('/');
    }
}
