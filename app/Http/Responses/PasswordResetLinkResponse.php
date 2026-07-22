<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;

class PasswordResetLinkResponse implements FailedPasswordResetLinkRequestResponse, SuccessfulPasswordResetLinkRequestResponse
{
    public const MESSAGE = 'Se houver uma conta associada a este e-mail, você receberá instruções para redefinir sua senha.';

    public function __construct(private readonly string $status)
    {
    }

    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => self::MESSAGE]);
        }

        return back()->with('status', self::MESSAGE);
    }
}
