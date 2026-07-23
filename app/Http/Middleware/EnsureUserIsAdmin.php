<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = mb_strtolower((string) $request->user()?->email);

        abort_unless($email !== '' && in_array($email, config('admin.emails', []), true), 403);

        return $next($request);
    }
}
