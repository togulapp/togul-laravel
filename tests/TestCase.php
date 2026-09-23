<?php

declare(strict_types=1);

namespace Togul\Laravel\Tests;

use OpenFeature\OpenFeatureAPI;
use OpenFeature\implementation\provider\NoOpProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Togul\Laravel\TogulServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [TogulServiceProvider::class];
    }

    protected function tearDown(): void
    {
        // The OpenFeature API is a process-wide singleton.
        OpenFeatureAPI::getInstance()->setProvider(new NoOpProvider());
        parent::tearDown();
    }
}
