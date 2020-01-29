<?php

namespace Willstickles\Zerobounce\Repository;

use Carbon\Carbon;

class ZeroBounce
{
    CONST CACHE_KEY = 'ZEROBOUNCE';

    /**
     * This is where I would cache a query
     *
     * @param  mixed $orderBy
     *
     * @return void
     */
    public function all ($orderBy)
    {
        $key = "all.{$orderBy}";

        $cacheKey = $this->getCacheKey($key);

        $expire_days = config('zerobounce.zerobounce.cache.expire');

        return cache()->remember($cacheKey, Carbon::now()->addDays($expire_days), function() {
            return true;
        });
    }
    

    /**
     * getCacheKey
     *
     * @param  mixed $key
     *
     * @return void
     */
    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }
}