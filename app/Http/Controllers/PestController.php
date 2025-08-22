<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pest;
use App\Models\Commodity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PestController extends Controller
{
    /**
     * Display the pest detection page.
     */
    public function index()
    {
        $recentPests = Pest::orderBy('created_at', 'desc')->limit(6)->get();
        $commodities = Commodity::select('id', 'name')->orderBy('name')->get();
        
        return Inertia::render('pest-detection', [
            'recentPests' => $recentPests,
            'commodities' => $commodities,
        ]);
    }



    /**
     * Display the specified pest.
     */
    public function show(Pest $pest)
    {
        return Inertia::render('pests/show', [
            'pest' => $pest,
        ]);
    }


}