<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthUserSetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        if (Auth::check()) {
            App::setLocale(Auth::user()->language);
        }
        return $next($request);
    }
}
