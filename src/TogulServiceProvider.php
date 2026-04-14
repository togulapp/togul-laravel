<?php

declare(strict_types=1);

namespace Togul\Laravel;

use Illuminate\Support\ServiceProvider;
use Togul\Config;
use Togul\FallbackMode;
use Togul\TogulClient;

class TogulServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/togul.php', 'togul');

        $this->app->singleton(TogulClient::class, function ($app) {
            $config = $app['config']['togul'];

            return new TogulClient(new Config(
                environment: $config['environment'],
                apiKey: $config['api_key'],
                timeout: (float) $config['timeout'],
                cacheTtl: (int) $config['cache_ttl'],
                fallbackMode: $config['fallback_mode'] === 'open'
                    ? FallbackMode::FailOpen
                    : FallbackMode::FailClosed,
                retryCount: (int) $config['retry_count'],
            ));
        });

        $this->app->singleton(TogulStreamService::class, function ($app) {
            return new TogulStreamService($app->make(TogulClient::class));
        });

        $this->app->alias(TogulClient::class, 'togul');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/togul.php' => config_path('togul.php'),
        ], 'togul-config');
    }
}
