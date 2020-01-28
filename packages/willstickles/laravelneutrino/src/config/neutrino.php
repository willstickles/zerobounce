<?php

return [
    'neutrino' => [
        'user_id' => env('MIX_NEUTRINO_USER_ID'),
        'api_key' => env('MIX_NEUTRINO_API_KEY'),

        'cache' => [
            'store' => env('CACHE_DRIVER'),
            'expire' => 600,
            'prefix' => 'neu_',
        ],
    ],
    
];