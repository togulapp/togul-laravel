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
TOGUL_BASE_URL=http://localhost:8080
TOGUL_API_KEY=your-environment-api-key
TOGUL_ENVIRONMENT=production
TOGUL_TIMEOUT=5
TOGUL_CACHE_TTL=30
TOGUL_FALLBACK_MODE=closed
TOGUL_RETRY_COUNT=2
```

## Usage

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

## Notes

- `TOGUL_API_KEY` must be an environment API key, not a user JWT.
- This package wraps `togul/php-sdk`; evaluation behavior follows the PHP SDK.
