<?php

namespace Willstickles\LaravelNeutrino\Facades;

use Illuminate\SUpport\Facades\Facade;

class Neutrino extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'willstickles-neutrino';
    }
}