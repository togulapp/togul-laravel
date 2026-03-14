<?php

declare(strict_types=1);

namespace Nori\Laravel;

use Illuminate\Support\ServiceProvider;
use Nori\Config;
use Nori\FallbackMode;
use Nori\NoriClient;

class NoriServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nori.php', 'nori');

        $this->app->singleton(NoriClient::class, function ($app) {
            $config = $app['config']['nori'];

            return new NoriClient(new Config(
                baseUrl: $config['base_url'],
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

        $this->app->alias(NoriClient::class, 'nori');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/nori.php' => config_path('nori.php'),
        ], 'nori-config');
    }
}
