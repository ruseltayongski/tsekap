<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResUserPrivilege
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
        $fnameParts = explode('-', Auth::user()->fname);
        Auth::user()->fname = end($fnameParts);
        $fname = null;
        foreach($fnameParts as $f){
        
           if($f == 'DSO'){
                $fname = $f;
           }
        }

        if (Auth::check() && Auth::user()->user_priv == 10 || Auth::user()->user_priv == 11 || (Auth::user()->user_priv == 6 && Auth::user()->facility_id) 
            || (Auth::user()->user_priv == 7 || Auth::user()->user_priv == 3 && $fname === 'DSO') || Auth::user()->user_priv == 8) {
            $allowedRoute = [
                'survelance',
                'survelance/*'
            ];

            foreach($allowedRoute as $route){
                if($request->is($route)){
                    return $next($request);
                }
            }
             // Return a 403 Forbidden response for all other routes
            //  return response()->json(['message' => 'Forbidden'], 403);
            // return Redirect::route('restrictAccess');
            return Redirect::route('survelance');

        }
        return $next($request);
    }
}
