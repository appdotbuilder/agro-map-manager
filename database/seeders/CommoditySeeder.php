<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commodity;
use App\Models\Variety;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commodities = [
            [
                'name' => 'Rice',
                'scientific_name' => 'Oryza sativa',
                'description' => 'Rice is the seed of the grass species Oryza sativa or Oryza glaberrima. It is the most widely consumed staple food for a large part of the world\'s human population.',
                'category' => 'Food Crop',
                'growing_conditions' => [
                    'temperature' => '20-35°C',
                    'rainfall' => '1500-2000mm annually',
                    'soil_type' => 'Clay loam to silty clay',
                    'ph' => '5.5-6.5'
                ],
                'harvest_info' => [
                    'maturity' => '90-150 days',
                    'yield_potential' => '4-8 tons/hectare',
                    'harvest_season' => 'Dry season'
                ]
            ],
            [
                'name' => 'Corn',
                'scientific_name' => 'Zea mays',
                'description' => 'Corn, also known as maize, is a cereal grain first domesticated by indigenous peoples in southern Mexico about 9,000 years ago.',
                'category' => 'Food Crop',
                'growing_conditions' => [
                    'temperature' => '21-27°C',
                    'rainfall' => '500-750mm per season',
                    'soil_type' => 'Well-drained loamy soil',
                    'ph' => '6.0-7.0'
                ],
                'harvest_info' => [
                    'maturity' => '90-120 days',
                    'yield_potential' => '5-10 tons/hectare',
                    'harvest_season' => 'End of rainy season'
                ]
            ],
            [
                'name' => 'Coffee',
                'scientific_name' => 'Coffea arabica',
                'description' => 'Coffee is a brewed drink prepared from roasted coffee beans, the seeds of berries from certain Coffea species.',
                'category' => 'Plantation Crop',
                'growing_conditions' => [
                    'temperature' => '15-24°C',
                    'rainfall' => '1200-2000mm annually',
                    'altitude' => '600-2000m above sea level',
                    'soil_type' => 'Well-drained volcanic soil'
                ],
                'harvest_info' => [
                    'maturity' => '3-4 years first harvest',
                    'yield_potential' => '1-3 tons/hectare',
                    'harvest_season' => 'April-August'
                ]
            ],
            [
                'name' => 'Tomato',
                'scientific_name' => 'Solanum lycopersicum',
                'description' => 'The tomato is the edible berry of the plant Solanum lycopersicum, commonly known as a tomato plant.',
                'category' => 'Horticulture',
                'growing_conditions' => [
                    'temperature' => '18-26°C',
                    'rainfall' => '600-1250mm annually',
                    'soil_type' => 'Well-drained sandy loam',
                    'ph' => '6.0-7.0'
                ],
                'harvest_info' => [
                    'maturity' => '70-90 days',
                    'yield_potential' => '40-60 tons/hectare',
                    'harvest_season' => 'Year-round in greenhouse'
                ]
            ],
            [
                'name' => 'Chili',
                'scientific_name' => 'Capsicum annuum',
                'description' => 'Chili peppers are varieties of the berry-fruit of plants from the genus Capsicum, which are members of the nightshade family.',
                'category' => 'Horticulture',
                'growing_conditions' => [
                    'temperature' => '20-30°C',
                    'rainfall' => '600-1250mm annually',
                    'soil_type' => 'Well-drained sandy loam',
                    'ph' => '6.0-7.0'
                ],
                'harvest_info' => [
                    'maturity' => '75-90 days',
                    'yield_potential' => '15-25 tons/hectare',
                    'harvest_season' => 'Dry season preferred'
                ]
            ]
        ];

        foreach ($commodities as $commodityData) {
            $commodity = Commodity::create($commodityData);

            // Create varieties for each commodity
            if ($commodity->name === 'Rice') {
                $varieties = [
                    [
                        'name' => 'IR64',
                        'description' => 'High-yielding semi-dwarf variety with good eating quality',
                        'maturity_days' => 115,
                        'potential_yield' => 6.5,
                        'agronomic_traits' => [
                            'plant_height' => '90-95cm',
                            'grain_type' => 'Long grain',
                            'milling_recovery' => '68-70%'
                        ],
                        'pest_susceptibility' => [
                            'brown_planthopper' => 'Susceptible',
                            'blast' => 'Moderately resistant',
                            'bacterial_blight' => 'Resistant'
                        ]
                    ],
                    [
                        'name' => 'Ciherang',
                        'description' => 'Indonesian high-yielding variety with good adaptability',
                        'maturity_days' => 116,
                        'potential_yield' => 7.0,
                        'agronomic_traits' => [
                            'plant_height' => '91-103cm',
                            'grain_type' => 'Long grain',
                            'milling_recovery' => '72-73%'
                        ],
                        'pest_susceptibility' => [
                            'brown_planthopper' => 'Resistant',
                            'blast' => 'Moderately resistant',
                            'bacterial_blight' => 'Resistant'
                        ]
                    ]
                ];
            } elseif ($commodity->name === 'Corn') {
                $varieties = [
                    [
                        'name' => 'Pioneer 21',
                        'description' => 'High-yielding hybrid variety suitable for various conditions',
                        'maturity_days' => 103,
                        'potential_yield' => 8.5,
                        'agronomic_traits' => [
                            'plant_height' => '210-250cm',
                            'ear_length' => '18-20cm',
                            'kernel_type' => 'Semi-flint'
                        ],
                        'pest_susceptibility' => [
                            'corn_borer' => 'Moderately resistant',
                            'fall_armyworm' => 'Susceptible',
                            'downy_mildew' => 'Resistant'
                        ]
                    ]
                ];
            } else {
                $varieties = [
                    [
                        'name' => $commodity->name . ' Standard Variety',
                        'description' => 'Standard commercial variety of ' . $commodity->name,
                        'maturity_days' => 90,
                        'potential_yield' => 5.0,
                        'agronomic_traits' => [
                            'plant_type' => 'Standard',
                            'adaptation' => 'Wide'
                        ]
                    ]
                ];
            }

            foreach ($varieties as $varietyData) {
                $varietyData['commodity_id'] = $commodity->id;
                Variety::create($varietyData);
            }
        }
    }
}