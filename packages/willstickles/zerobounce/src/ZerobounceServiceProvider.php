<?php

namespace Willstickles\Zerobounce;

use Illuminate\Support\ServiceProvider;
use Willstickles\Zerobounce\ZeroBounce;

class ZeroBounceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('willstickles-zerobounce', function() {
            return new ZeroBounce();
        });

        $this->mergeConfigFrom( __DIR__.'/config/zerobounce.php', 'zerobounce');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/zerobounce.php' => config_path('zerobounce.php')
        ], 'zerobounce-config');

        $this->publishes([
            __DIR__.'/js/components' => resource_path('js/components')
        ], 'vue-components');

        $this->publishes([
            __DIR__.'/js/app.js' => resource_path('js')
        ], 'zerobounce-js');

        $this->loadRoutesFrom( __DIR__.'/routes/web.php');
        $this->loadViewsFrom( __DIR__.'/views', 'willstickles\zerobounce');

    }
}
