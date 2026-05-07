# Togul Laravel SDK

Laravel integration layer for the Togul PHP SDK.

## Install

```bash
composer require togul/laravel-sdk
php artisan vendor:publish --tag=togul-config
```

## Configuration

Add to `.env`:

```dotenv
TOGUL_API_KEY=your-environment-api-key
TOGUL_ENVIRONMENT=production
TOGUL_TIMEOUT=5
TOGUL_CACHE_TTL=30
TOGUL_FALLBACK_MODE=closed
TOGUL_RETRY_COUNT=2
```

## Usage

### Boolean flag (on/off)

Via facade:

```php
use Togul\Laravel\Facades\Togul;

$enabled = Togul::isEnabled('new-dashboard', [
    'user_id' => (string) auth()->id(),
]);
```

Via dependency injection:

```php
use Togul\TogulClient;

public function __invoke(TogulClient $togul)
{
    $enabled = $togul->isEnabled('new-dashboard', [
        'user_id' => (string) auth()->id(),
    ]);
}
```

Via middleware:

```php
Route::get('/dashboard', DashboardController::class)
    ->middleware('togul:new-dashboard');
```

### Multi-variant flags

Use typed facade methods to read flag values beyond boolean:

```php
use Togul\Laravel\Facades\Togul;

$context = ['user_id' => (string) auth()->id()];

// String variant
$theme = Togul::evaluateString('ui-theme', $context, fallback: 'default');

// Number variant
$limit = Togul::evaluateNumber('rate-limit', $context, fallback: 100.0);

// Boolean variant
$flag = Togul::evaluateBool('beta-feature', $context, fallback: false);

// JSON variant
$config = Togul::evaluateJSON('feature-config', $context, fallback: null);
```

### Full evaluation result

```php
$result = Togul::evaluateResult('checkout-flow', $context);

$result->enabled;              // bool
$result->flagKey;              // string
$result->valueType;            // 'boolean' | 'string' | 'number' | 'json'
$result->reason;               // string

$result->boolValue(false);
$result->stringValue('');
$result->numberValue(0.0);
$result->jsonValue(null);
```

### Cache invalidation

```php
Togul::invalidateFlag('new-dashboard'); // single flag
Togul::invalidateCache();               // all flags
```

## Notes

- `TOGUL_API_KEY` must be an environment API key, not a user JWT.
- This package wraps `togul/php-sdk`; evaluation behavior follows the PHP SDK.
- Typed accessors return the fallback if the flag is disabled or the value type does not match.
