<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeatureIsEnabled
{
    /**
     * Prevents access to routes whose server-side feature flag is disabled.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        abort_unless(config("app_settings.flags.{$feature}"), 404);

        return $next($request);
    }
}
