<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB; // added for tsekapv2
use Illuminate\Support\Facades\Log; // added for tsekapv2

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // added for tsekapv2
        DB::listen(function ($query) {
            Log::info(
                'Query Time: ' . $query->time . 'ms [' . $query->sql . ']',
                $query->bindings
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
