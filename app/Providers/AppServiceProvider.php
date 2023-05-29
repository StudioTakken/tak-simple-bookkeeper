<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // prevent Lazy loading
        // https://laravel.com/docs/8.x/eloquent-relationships#lazy-eager-loading
        Model::preventLazyLoading(!app()->isProduction());


    }
}
