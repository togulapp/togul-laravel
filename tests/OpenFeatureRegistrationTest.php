<?php

declare(strict_types=1);

namespace Togul\Laravel\Tests;

use OpenFeature\OpenFeatureAPI;
use ReflectionProperty;
use Togul\OpenFeature\TogulProvider;
use Togul\TogulClient;

class OpenFeatureRegistrationTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('togul.api_key', 'test-key');
        $app['config']->set('togul.openfeature.targeting_key_attribute', 'account_id');
    }

    public function testRegistersTogulAsGlobalProvider(): void
    {
        $provider = OpenFeatureAPI::getInstance()->getProvider();

        $this->assertInstanceOf(TogulProvider::class, $provider);
        $this->assertSame('Togul', OpenFeatureAPI::getInstance()->getProviderMetadata()->getName());
        $this->assertSame($provider, $this->app->make(TogulProvider::class));
    }

    public function testProviderSharesTheClientSingleton(): void
    {
        $this->assertSame(
            $this->app->make(TogulClient::class),
            $this->app->make(TogulProvider::class)->getClient(),
        );
        $this->assertSame($this->app->make(TogulClient::class), $this->app->make('togul'));
    }

    public function testTargetingKeyAttributeComesFromConfig(): void
    {
        $property = new ReflectionProperty(TogulProvider::class, 'targetingKeyAttribute');

        $this->assertSame('account_id', $property->getValue($this->app->make(TogulProvider::class)));
    }
}
