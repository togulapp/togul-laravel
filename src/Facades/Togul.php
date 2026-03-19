<?php

declare(strict_types=1);

namespace Togul\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled(string $key, array $context = [])
 * @method static void invalidateCache()
 *
 * @see \Togul\TogulClient
 */
class Togul extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'togul';
    }
}
