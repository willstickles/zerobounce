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
        require __DIR__ . '/routes/routes.php';

        $this->publishes([
            __DIR__.'/config/neutrino.php' => config_path('neutrino.php'),
        ]);
    }
}
