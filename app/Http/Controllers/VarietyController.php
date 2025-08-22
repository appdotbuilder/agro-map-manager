<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Variety;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VarietyController extends Controller
{
    /**
     * Display a listing of varieties.
     */
    public function index(Request $request)
    {
        $query = Variety::with('commodity');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('commodity', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->commodity_id) {
            $query->where('commodity_id', $request->commodity_id);
        }

        $varieties = $query->orderBy('name')->paginate(12);

        return Inertia::render('varieties/index', [
            'varieties' => $varieties,
            'filters' => $request->only(['search', 'commodity_id']),
        ]);
    }

    /**
     * Display the specified variety.
     */
    public function show(Variety $variety)
    {
        $variety->load('commodity');
        
        return Inertia::render('varieties/show', [
            'variety' => $variety,
        ]);
    }
}