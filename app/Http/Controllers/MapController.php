<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Commodity;
use App\Models\CommodityDistribution;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    /**
     * Display the main map page.
     */
    public function index(Request $request)
    {
        $provinces = Province::select('id', 'name', 'code')->orderBy('name')->get();
        $commodities = Commodity::select('id', 'name', 'category')->orderBy('name')->get();
        
        // Get initial commodity distributions for map display
        $distributions = CommodityDistribution::with(['commodity', 'province', 'regency', 'district'])
            ->where('year', date('Y'))
            ->limit(100)
            ->get();

        return Inertia::render('welcome', [
            'provinces' => $provinces,
            'commodities' => $commodities,
            'distributions' => $distributions,
        ]);
    }


}