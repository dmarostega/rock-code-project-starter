<?php

namespace App\Http\Controllers;

use App\Support\Seo\SeoData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthPageController extends Controller
{
    public function login(): Response
    {
        return Inertia::render('auth/Login', ['seo' => SeoData::page('Entrar')->toArray()]);
    }

    public function register(): Response
    {
        return Inertia::render('auth/Register', ['seo' => SeoData::page('Criar conta')->toArray()]);
    }

    public function forgotPassword(): Response
    {
        return Inertia::render('auth/ForgotPassword', ['seo' => SeoData::page('Recuperar senha')->toArray()]);
    }

    public function resetPassword(Request $request, string $token): Response
    {
        return Inertia::render('auth/ResetPassword', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
            'seo' => SeoData::page('Redefinir senha')->toArray(),
        ]);
    }
}
