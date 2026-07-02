<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        return response()->view('sitemap', ['urls' => [url('/'), url('/login'), url('/register')]])->header('Content-Type', 'application/xml');
    }
}
