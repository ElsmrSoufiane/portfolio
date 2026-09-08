<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const AVAILABLE_LOCALES = ['en', 'fr', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (is_string($locale) && in_array($locale, self::AVAILABLE_LOCALES, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
