<?php

return [
    'api_key' => env('TOGUL_API_KEY', ''), // environment API key used for evaluate/stream requests
    'environment' => env('TOGUL_ENVIRONMENT', 'production'),
    'timeout' => env('TOGUL_TIMEOUT', 5.0),
    'cache_ttl' => env('TOGUL_CACHE_TTL', 30),
    'retry_count' => env('TOGUL_RETRY_COUNT', 2),

    // Used only when open-feature/sdk is installed.
    'openfeature' => [
        'register' => env('TOGUL_OPENFEATURE_REGISTER', true), // set Togul as the global OpenFeature provider
        'targeting_key_attribute' => env('TOGUL_OPENFEATURE_TARGETING_KEY', 'user_id'),
    ],
];
