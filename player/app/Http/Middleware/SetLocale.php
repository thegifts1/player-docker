<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (isset($user)) {
            App::setLocale($user['lang']);

            return $next($request);
        } else {
            if (Cache::get($_SERVER['REMOTE_ADDR'])) {
                App::setLocale(Cache::get($_SERVER['REMOTE_ADDR'] . '-lang'));

                return $next($request);
            } else {
                Cache::put($_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR'], now()->addYears(10));
                Cache::put($_SERVER['REMOTE_ADDR'] . '-lang', App::getLocale(), now()->addYears(10));
                Cache::put($_SERVER['REMOTE_ADDR'] . '-darkTheme', 0, now()->addYears(10));

                App::setLocale(Cache::get($_SERVER['REMOTE_ADDR'] . '-lang'));

                return $next($request);
            }
        }

        return $next($request);
    }
}
