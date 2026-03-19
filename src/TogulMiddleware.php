<?php

declare(strict_types=1);

namespace Togul\Laravel;

use Closure;
use Illuminate\Http\Request;
use Togul\TogulClient;
use Symfony\Component\HttpFoundation\Response;

class TogulMiddleware
{
    public function __construct(
        private readonly TogulClient $client,
    ) {}

    /**
     * Check if a feature flag is enabled before proceeding.
     *
     * Usage in routes:
     *   Route::get('/dashboard', DashboardController::class)
     *       ->middleware('togul:new-dashboard');
     */
    public function handle(Request $request, Closure $next, string $flagKey): Response
    {
        $context = [
            'user_id' => (string) ($request->user()?->id ?? ''),
        ];

        if (!$this->client->isEnabled($flagKey, $context)) {
            abort(404);
        }

        return $next($request);
    }
}
