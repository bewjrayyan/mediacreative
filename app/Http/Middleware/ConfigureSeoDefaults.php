<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\SeoManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registered on web stack in bootstrap/app.php. Calls SeoManager::applyDefaults() for public pages.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
final class ConfigureSeoDefaults
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is('admin', 'admin/*', 'api', 'api/*', 'up')) {
            $this->seo->applyDefaults();
        }

        return $next($request);
    }
}
