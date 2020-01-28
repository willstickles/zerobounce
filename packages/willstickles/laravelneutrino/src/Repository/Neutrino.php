<?php

namespace Willstickles\LaravelNeutrino\Repository;

use Carbon\Carbon;

class Neutrino
{
    CONST CACHE_KEY = 'neutrino';

    public function all ($orderBy)
    {
        $key = "all.{$orderBy}";

        $cacheKey = $this->getCacheKey($key);

        $expire_days = config('neutrino.neutrino.cache');
        dd($expire_days);

        return cache()->remember($cacheKey, Carbon::now()->addDays($expire_days));
    }
    

    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }
}