<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pest;
use Illuminate\Http\Request;

class PestSearchController extends Controller
{
    /**
     * Search for pests based on symptoms or commodity.
     */
    public function store(Request $request)
    {
        $request->validate([
            'symptoms' => 'nullable|string|max:500',
            'commodity_id' => 'nullable|exists:commodities,id',
            'type' => 'nullable|in:pest,disease',
        ]);

        $query = Pest::query();

        if ($request->symptoms) {
            $symptoms = strtolower($request->symptoms);
            $query->where(function ($q) use ($symptoms) {
                $q->where('name', 'like', '%' . $symptoms . '%')
                  ->orWhere('description', 'like', '%' . $symptoms . '%')
                  ->orWhereRaw('LOWER(JSON_EXTRACT(symptoms, "$")) LIKE ?', ['%' . $symptoms . '%']);
            });
        }

        if ($request->commodity_id) {
            $query->whereRaw('JSON_CONTAINS(affected_commodities, ?)', ['"' . $request->commodity_id . '"']);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $pests = $query->orderBy('name')->get();

        return response()->json($pests);
    }
}