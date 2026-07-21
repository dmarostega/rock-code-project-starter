<?php

use App\Http\Middleware\CaptureGrowthAttribution;
use App\Http\Middleware\HandleInertiaRequests;
use App\Support\Seo\SeoData;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            CaptureGrowthAttribution::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpExceptionInterface $exception, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $status = $exception->getStatusCode();
            $component = match ($status) {
                403 => 'Errors/Forbidden',
                404 => 'Errors/NotFound',
                419 => 'Errors/PageExpired',
                default => null,
            };

            if ($component === null) {
                return null;
            }

            return Inertia::render($component, [
                'seo' => SeoData::privatePage("Erro {$status}")->toArray(),
            ])->toResponse($request)->setStatusCode($status);
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (
                $request->expectsJson()
                || $exception instanceof AuthenticationException
                || $exception instanceof HttpExceptionInterface
                || $exception instanceof ValidationException
            ) {
                return null;
            }

            return Inertia::render('Errors/ServerError', [
                'seo' => SeoData::privatePage('Erro interno')->toArray(),
            ])->toResponse($request)->setStatusCode(500);
        });
    })
    ->create();
