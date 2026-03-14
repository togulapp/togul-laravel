<?php

declare(strict_types=1);

namespace Nori\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled(string $key, array $context = [])
 * @method static void invalidateCache()
 *
 * @see \Nori\NoriClient
 */
class Nori extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'nori';
    }
}
