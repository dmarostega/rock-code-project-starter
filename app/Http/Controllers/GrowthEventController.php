<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrowthEventRequest;
use App\Services\GrowthTracker;
use Illuminate\Http\JsonResponse;

class GrowthEventController extends Controller
{
    public function store(StoreGrowthEventRequest $request, GrowthTracker $tracker): JsonResponse
    {
        $tracker->record($request, $request->validated());

        return response()->json(status: 202);
    }
}
