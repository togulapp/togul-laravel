<?php

declare(strict_types=1);

namespace Togul\Laravel;

use Illuminate\Support\ServiceProvider;
use OpenFeature\OpenFeatureAPI;
use Togul\Config;
use Togul\OpenFeature\TogulProvider;
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
                retryCount: (int) $config['retry_count'],
            ));
        });

        $this->app->singleton(TogulStreamService::class, function ($app) {
            return new TogulStreamService($app->make(TogulClient::class));
        });

        $this->app->alias(TogulClient::class, 'togul');

        $this->app->singleton(TogulProvider::class, function ($app) {
            return new TogulProvider(
                $app->make(TogulClient::class),
                $app['config']['togul.openfeature.targeting_key_attribute'] ?? 'user_id',
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/togul.php' => config_path('togul.php'),
        ], 'togul-config');

        // Check the SDK, not TogulProvider: autoloading a class whose parent
        // (AbstractProvider) is missing is a fatal error.
        if (class_exists(OpenFeatureAPI::class) && ($this->app['config']['togul.openfeature.register'] ?? true)) {
            OpenFeatureAPI::getInstance()->setProvider($this->app->make(TogulProvider::class));
        }
    }
}
