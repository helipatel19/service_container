<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErrorsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/errors' => resource_path('views/errors'),
            __DIR__.'/svg' => public_path('svg'),
        ], 'laravel-collective-errors');
    }
}
