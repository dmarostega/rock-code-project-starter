<?php

namespace App\Http\Controllers;

use App\Services\AuditLogger;
use App\Support\Seo\SeoData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request, AuditLogger $auditLogger): Response
    {
        $auditLogger->record('admin.accessed', $request->user());

        return Inertia::render('Admin/Dashboard', [
            'seo' => SeoData::privatePage('Administração')->toArray(),
        ]);
    }
}
