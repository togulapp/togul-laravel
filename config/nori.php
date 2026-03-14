<?php

return [
    'base_url' => env('NORI_BASE_URL', 'http://localhost:8080'),
    'api_key' => env('NORI_API_KEY', ''),
    'environment' => env('NORI_ENVIRONMENT', 'production'),
    'timeout' => env('NORI_TIMEOUT', 5.0),
    'cache_ttl' => env('NORI_CACHE_TTL', 30),
    'fallback_mode' => env('NORI_FALLBACK_MODE', 'closed'), // 'open' or 'closed'
    'retry_count' => env('NORI_RETRY_COUNT', 2),
];
