<?php

namespace App\Http\Middleware\TsekapV2;

use Closure;

// XSRF Token Middleware for Tsekapv2
class VerifyXsrfTokenV2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headerToken = $request->header('X-XSRF-TOKEN');
        $cookieToken = $request->cookie('XSRF-TOKEN');

        if(!$headerToken && !$cookieToken){
            return response()->json(['error' => 'XSRF token is missing.'], 403);
        }

        return $next($request);
    }
}
