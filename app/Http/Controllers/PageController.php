<?php

namespace App\Http\Controllers;

use App\Support\Seo\SeoData;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', ['seo' => SeoData::page('Starter Laravel para novos produtos', 'Base Rock Code com autenticação, SEO, growth e mídia.')->toArray()]);
    }

    public function dashboard(): Response
    {
        return Inertia::render('Dashboard', ['seo' => SeoData::page('Dashboard')->toArray()]);
    }
}
