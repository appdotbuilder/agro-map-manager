<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommodityDistribution;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Get regencies by province.
     */
    public function index(Request $request)
    {
        if ($request->has('province_id')) {
            $request->validate([
                'province_id' => 'required|exists:provinces,id'
            ]);

            $regencies = Regency::where('province_id', $request->province_id)
                ->select('id', 'name', 'code')
                ->orderBy('name')
                ->get();

            return response()->json($regencies);
        }

        if ($request->has('regency_id')) {
            $request->validate([
                'regency_id' => 'required|exists:regencies,id'
            ]);

            $districts = District::where('regency_id', $request->regency_id)
                ->select('id', 'name', 'code')
                ->orderBy('name')
                ->get();

            return response()->json($districts);
        }

        // Get commodity distribution data based on filters
        $request->validate([
            'commodity_id' => 'nullable|exists:commodities,id',
            'province_id' => 'nullable|exists:provinces,id',
            'regency_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        $query = CommodityDistribution::with(['commodity', 'province', 'regency', 'district']);

        if ($request->commodity_id) {
            $query->where('commodity_id', $request->commodity_id);
        }

        if ($request->province_id) {
            $query->where('province_id', $request->province_id);
        }

        if ($request->regency_id) {
            $query->where('regency_id', $request->regency_id);
        }

        if ($request->district_id) {
            $query->where('district_id', $request->district_id);
        }

        $year = $request->year ?? date('Y');
        $query->where('year', $year);

        $distributions = $query->limit(200)->get();

        return response()->json($distributions);
    }
}