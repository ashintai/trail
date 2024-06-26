<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //httpをhttpsへ強制移行
        if (\App::enviroment(['production'])){
            \URL::forceScheme('https');
        }
    }
}
