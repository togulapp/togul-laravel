<?php

declare(strict_types=1);

namespace Togul\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled(string $key, array $context = [])
 * @method static \Togul\EvaluateResult evaluateResult(string $key, array $context = [])
 * @method static bool evaluateBool(string $key, array $context = [], bool $fallback = false)
 * @method static string evaluateString(string $key, array $context = [], string $fallback = '')
 * @method static float evaluateNumber(string $key, array $context = [], float $fallback = 0.0)
 * @method static mixed evaluateJSON(string $key, array $context = [], mixed $fallback = null)
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
