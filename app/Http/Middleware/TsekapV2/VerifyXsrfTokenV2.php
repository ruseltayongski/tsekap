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
        $xsrfheaderToken = $request->header('X-XSRF-TOKEN');
        $xsrfCookieToken1 = $request->cookie('XSRF-TOKEN');
        $xsrfheaderToken2 = $request->cookie('X-XSRF-TOKEN');

        if(!$xsrfheaderToken && !$xsrfCookieToken1 && !$xsrfheaderToken2) {
            return response()->json(['error' => 'XSRF token is missing.'], 403);
        }

        return $next($request);
    }
}
