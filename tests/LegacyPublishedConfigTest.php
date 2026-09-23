<?php

declare(strict_types=1);

namespace Togul\Laravel\Tests;

use OpenFeature\OpenFeatureAPI;
use Togul\OpenFeature\TogulProvider;

class LegacyPublishedConfigTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        // A config/togul.php published before the "openfeature" key existed.
        $app['config']->set('togul', [
            'api_key' => 'test-key',
            'environment' => 'production',
            'timeout' => 5.0,
            'cache_ttl' => 30,
            'retry_count' => 2,
        ]);
    }

    public function testFallsBackToDefaults(): void
    {
        $this->assertInstanceOf(TogulProvider::class, OpenFeatureAPI::getInstance()->getProvider());
    }
}
