<?php

namespace Willstickles\LaravelNeutrino\Facades;

use Illuminate\SUpport\Facades\Facade;

class Neutrino extends Facade
{
    /**
     * Get the registered name of the component.
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'willstickles-neutrino';
    }
}