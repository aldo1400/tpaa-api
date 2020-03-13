<?php

namespace App\Providers;

use App\Movilidad;
use App\Observers\MovilidadObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Movilidad::observe(MovilidadObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
