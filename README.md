# Nori Laravel SDK

Laravel integration layer for the Nori PHP SDK.

## Install

```bash
composer require nori/laravel-sdk
php artisan vendor:publish --tag=nori-config
```

## Configuration

Add to `.env`:

```dotenv
NORI_BASE_URL=http://localhost:8080
NORI_API_KEY=your-environment-api-key
NORI_ENVIRONMENT=production
NORI_TIMEOUT=5
NORI_CACHE_TTL=30
NORI_FALLBACK_MODE=closed
NORI_RETRY_COUNT=2
```

## Usage

Via facade:

```php
use Nori\Laravel\Facades\Nori;

$enabled = Nori::isEnabled('new-dashboard', [
    'user_id' => (string) auth()->id(),
]);
```

Via dependency injection:

```php
use Nori\NoriClient;

public function __invoke(NoriClient $nori)
{
    $enabled = $nori->isEnabled('new-dashboard', [
        'user_id' => (string) auth()->id(),
    ]);
}
```

Via middleware:

```php
Route::get('/dashboard', DashboardController::class)
    ->middleware('nori:new-dashboard');
```

## Notes

- `NORI_API_KEY` must be an environment API key, not a user JWT.
- This package wraps `nori/php-sdk`; evaluation behavior follows the PHP SDK.
