<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommodityDistribution;
use App\Models\Commodity;
use App\Models\Province;
use App\Models\Regency;

class CommodityDistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commodities = Commodity::all();
        $provinces = Province::with('regencies')->get();
        $currentYear = date('Y');

        foreach ($commodities as $commodity) {
            foreach ($provinces as $province) {
                // Create province-level distribution
                $provinceDistribution = [
                    'commodity_id' => $commodity->id,
                    'province_id' => $province->id,
                    'area_hectares' => random_int(1000, 50000),
                    'year' => $currentYear,
                    'environmental_data' => [
                        'average_temperature' => random_int(20, 32),
                        'annual_rainfall' => random_int(800, 2500),
                        'soil_ph' => round(random_int(55, 75) / 10, 1),
                        'humidity' => random_int(60, 90)
                    ]
                ];
                
                $provinceDistribution['production_tons'] = $provinceDistribution['area_hectares'] * (random_int(2, 8) + (random_int(0, 9) / 10));
                $provinceDistribution['productivity'] = round($provinceDistribution['production_tons'] / $provinceDistribution['area_hectares'], 2);

                CommodityDistribution::create($provinceDistribution);

                // Create regency-level distributions for some regencies
                foreach ($province->regencies->take(2) as $regency) {
                    $regencyAreaRatio = random_int(10, 40) / 100; // 10-40% of province area
                    $regencyDistribution = [
                        'commodity_id' => $commodity->id,
                        'province_id' => $province->id,
                        'regency_id' => $regency->id,
                        'area_hectares' => $provinceDistribution['area_hectares'] * $regencyAreaRatio,
                        'year' => $currentYear,
                        'environmental_data' => [
                            'average_temperature' => $provinceDistribution['environmental_data']['average_temperature'] + random_int(-2, 2),
                            'annual_rainfall' => $provinceDistribution['environmental_data']['annual_rainfall'] + random_int(-200, 200),
                            'soil_ph' => $provinceDistribution['environmental_data']['soil_ph'] + (random_int(-5, 5) / 10),
                            'humidity' => $provinceDistribution['environmental_data']['humidity'] + random_int(-10, 10)
                        ]
                    ];

                    $regencyDistribution['production_tons'] = $regencyDistribution['area_hectares'] * (random_int(2, 8) + (random_int(0, 9) / 10));
                    $regencyDistribution['productivity'] = round($regencyDistribution['production_tons'] / $regencyDistribution['area_hectares'], 2);

                    CommodityDistribution::create($regencyDistribution);
                }
            }
        }

        // Add historical data for the past 2 years
        for ($year = $currentYear - 2; $year < $currentYear; $year++) {
            foreach ($commodities->take(2) as $commodity) { // Only for first 2 commodities to limit data
                foreach ($provinces->take(2) as $province) { // Only for first 2 provinces
                    $baseArea = random_int(1000, 30000);
                    $distribution = [
                        'commodity_id' => $commodity->id,
                        'province_id' => $province->id,
                        'area_hectares' => $baseArea,
                        'year' => $year,
                        'environmental_data' => [
                            'average_temperature' => random_int(20, 32),
                            'annual_rainfall' => random_int(800, 2500),
                            'soil_ph' => round(random_int(55, 75) / 10, 1),
                            'humidity' => random_int(60, 90)
                        ]
                    ];
                    
                    $distribution['production_tons'] = $baseArea * (random_int(2, 8) + (random_int(0, 9) / 10));
                    $distribution['productivity'] = round($distribution['production_tons'] / $distribution['area_hectares'], 2);

                    CommodityDistribution::create($distribution);
                }
            }
        }
    }
}