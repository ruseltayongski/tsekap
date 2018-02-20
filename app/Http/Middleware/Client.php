<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Client
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
        if ( Auth::check() && (Auth::user()->user_priv == 0 || Auth::user()->user_priv == 2 || Auth::user()->user_priv == 4) )
        {
            return $next($request);
        }

        return redirect('home');
    }
}
