<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureGrowthAttribution
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('growth.enabled') && $request->isMethod('GET')) {
            $attribution = $request->only(config('growth.attribution_keys'));

            if ($attribution !== []) {
                $request->session()->put('growth.attribution', array_filter($attribution));
            }
        }

        return $next($request);
    }
}
