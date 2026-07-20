<?php

namespace App\Http\Controllers;

use App\Support\Seo\SeoData;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'seo' => SeoData::privatePage('Administração')->toArray(),
        ]);
    }
}
