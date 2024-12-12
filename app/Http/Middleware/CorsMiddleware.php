<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        $response = $next($request);

        // Allow from any origin
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        // Allow specific methods
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        
        // Allow specific headers
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-Token');
        
        // Allow credentials
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        
        // Allow exposed headers
        $response->headers->set('Access-Control-Expose-Headers', 'Authorization, authenticated');
        
        // Max age for preflight request
        $response->headers->set('Access-Control-Max-Age', '86400');
        
        // Handle preflight requests
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(204);
            $response->headers->set('Content-Length', '0');
            $response->headers->set('Content-Type', 'text/plain');
        }

        return $response;
    }
}
