<?php

return [
    'base_url' => env('TOGUL_BASE_URL', 'http://localhost:8080'),
    'api_key' => env('TOGUL_API_KEY', ''), // environment API key used for evaluate/stream requests
    'environment' => env('TOGUL_ENVIRONMENT', 'production'),
    'timeout' => env('TOGUL_TIMEOUT', 5.0),
    'cache_ttl' => env('TOGUL_CACHE_TTL', 30),
    'fallback_mode' => env('TOGUL_FALLBACK_MODE', 'closed'), // 'open' or 'closed'
    'retry_count' => env('TOGUL_RETRY_COUNT', 2),
];
