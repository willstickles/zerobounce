<?php

return [
    'zerobounce' => [
        'user_id' => env('MIX_ZEROBOUNCE_USER_ID'),
        'api_key' => env('MIX_ZEROBOUNCE_API_KEY'),

        'cache' => [
            'expire' => env('MIX_CACHE_EXPIRE_DAYS'),
            'prefix' => env('MIX_CACHE_PREFIX'),
        ],
    ],
    
];