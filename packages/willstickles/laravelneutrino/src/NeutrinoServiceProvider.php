<?php

namespace Willstickles\LaravelNeutrino;

use Illuminate\Support\ServiceProvider;
use Willstickles\LaravelNeutrino\Neutrino;

class NeutrinoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('willstickles-neutrino', function() {
            return new Neutrino();
        });

        $this->mergeConfigFrom( __DIR__.'/config/neutrino.php', 'neutrino');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/neutrino.php' => config_path('neutrino.php'),
            __DIR__.'/components' => resource_path('js/components')
        ]);
        $this->loadRoutesFrom( __DIR__.'/routes/web.php');
        $this->loadViewsFrom( __DIR__.'/views', 'willstickles\laravelneutrino');

    }
}
