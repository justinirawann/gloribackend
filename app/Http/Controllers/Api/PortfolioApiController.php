<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;

class PortfolioApiController extends Controller
{
    public function getByService($serviceId)
    {
        $portfolios = Portfolio::where('service_id', $serviceId)->get();
        return response()->json($portfolios);
    }

    public function show($id)
    {
        $portfolio = Portfolio::with([
            'displayedImages' => function($query) {
                $query->orderBy('display_order');
            },
            'images'
        ])->findOrFail($id);
        
        return response()->json($portfolio);
    }
}
