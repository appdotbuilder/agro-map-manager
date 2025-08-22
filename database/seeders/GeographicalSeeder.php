<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

class GeographicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample provinces
        $provinces = [
            ['name' => 'West Java', 'code' => 'JB', 'latitude' => -6.9175, 'longitude' => 107.6191],
            ['name' => 'Central Java', 'code' => 'JT', 'latitude' => -7.1509, 'longitude' => 110.1403],
            ['name' => 'East Java', 'code' => 'JI', 'latitude' => -7.5360, 'longitude' => 112.2384],
            ['name' => 'North Sumatra', 'code' => 'SU', 'latitude' => 3.5952, 'longitude' => 98.6722],
            ['name' => 'South Sulawesi', 'code' => 'SN', 'latitude' => -3.6687, 'longitude' => 119.9740],
        ];

        foreach ($provinces as $provinceData) {
            $province = Province::create($provinceData);

            // Create sample regencies for each province
            $regencies = [
                ['name' => $province->name . ' Regency 1', 'code' => $province->code . '01'],
                ['name' => $province->name . ' Regency 2', 'code' => $province->code . '02'],
                ['name' => $province->name . ' Regency 3', 'code' => $province->code . '03'],
            ];

            foreach ($regencies as $regencyData) {
                $regencyData['province_id'] = $province->id;
                $regency = Regency::create($regencyData);

                // Create sample districts for each regency
                $districts = [
                    ['regency_id' => $regency->id, 'name' => $regency->name . ' District 1', 'code' => $regency->code . '001'],
                    ['regency_id' => $regency->id, 'name' => $regency->name . ' District 2', 'code' => $regency->code . '002'],
                ];

                foreach ($districts as $districtData) {
                    District::create($districtData);
                }
            }
        }
    }
}