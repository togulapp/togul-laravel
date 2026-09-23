<?php

declare(strict_types=1);

namespace Togul\Laravel\Tests;

use OpenFeature\OpenFeatureAPI;
use OpenFeature\implementation\provider\NoOpProvider;
use Togul\OpenFeature\TogulProvider;

class OpenFeatureRegistrationDisabledTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        OpenFeatureAPI::getInstance()->setProvider(new NoOpProvider());
        $app['config']->set('togul.openfeature.register', false);
    }

    public function testLeavesGlobalProviderUntouched(): void
    {
        $this->assertInstanceOf(NoOpProvider::class, OpenFeatureAPI::getInstance()->getProvider());
        $this->assertInstanceOf(TogulProvider::class, $this->app->make(TogulProvider::class));
    }
}
