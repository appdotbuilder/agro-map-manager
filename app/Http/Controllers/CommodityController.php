<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\Variety;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommodityController extends Controller
{
    /**
     * Display a listing of commodities.
     */
    public function index(Request $request)
    {
        $query = Commodity::with('varieties');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('scientific_name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $commodities = $query->orderBy('name')->paginate(12);
        $categories = Commodity::select('category')->distinct()->orderBy('category')->pluck('category');

        return Inertia::render('commodities/index', [
            'commodities' => $commodities,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    /**
     * Display the specified commodity.
     */
    public function show(Commodity $commodity)
    {
        $commodity->load(['varieties', 'distributions.province', 'distributions.regency']);
        
        return Inertia::render('commodities/show', [
            'commodity' => $commodity,
        ]);
    }
}