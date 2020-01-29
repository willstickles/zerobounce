<?php

namespace Willstickles\Zerobounce\Facades;

use Illuminate\Support\Facades\Facade;

class ZeroBounce extends Facade
{
    /**
     * Get the registered name of the component.
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'willstickles-zerobounce';
    }
}