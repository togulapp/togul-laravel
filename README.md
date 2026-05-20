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

### Via facade

```php
use Togul\Laravel\Facades\Togul;

$result = Togul::evaluate('new-dashboard', [
    'user_id' => (string) auth()->id(),
]);

var_dump($result->enabled);   // true
var_dump($result->valueType); // "string"
var_dump($result->value);     // "dark_mode"
var_dump($result->reason);    // "rule_match"
```

### Via dependency injection

```php
use Togul\TogulClient;

public function __invoke(TogulClient $togul)
{
    $result = $togul->evaluate('new-dashboard', [
        'user_id' => (string) auth()->id(),
    ]);
}
```

### Via middleware

```php
Route::get('/dashboard', DashboardController::class)
    ->middleware('togul:new-dashboard');
```

## EvaluateResult

`evaluate()` returns an `EvaluateResult` object:

```php
$result->flagKey;    // string  — flag identifier
$result->enabled;    // bool    — whether the flag is on
$result->valueType;  // string  — "boolean" | "string" | "number" | "json"
$result->value;      // mixed   — the resolved value
$result->reason;     // string  — e.g. "rule_match", "default"
```

### Cache invalidation

```php
Togul::invalidateFlag('new-dashboard'); // single flag
Togul::invalidateCache();               // all flags
```

## Notes

- `TOGUL_API_KEY` must be an environment API key, not a user JWT.
- This package wraps `togul/php-sdk`; evaluation behavior follows the PHP SDK.
