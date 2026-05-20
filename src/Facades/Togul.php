<?php

declare(strict_types=1);

namespace Togul\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Togul\EvaluateResult evaluate(string $key, array $context = [])
 * @method static void invalidateCache()
 * @method static void invalidateFlag(string $key)
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
