<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pest;
use App\Models\Commodity;

class PestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pests = [
            [
                'name' => 'Brown Planthopper',
                'scientific_name' => 'Nilaparvata lugens',
                'type' => 'pest',
                'description' => 'A major pest of rice that causes hopperburn and transmits viral diseases.',
                'symptoms' => [
                    'Yellowing and drying of rice plants',
                    'Stunted growth',
                    'Honeydew deposits on leaves',
                    'Sooty mold on plants'
                ],
                'control_methods' => [
                    'Use resistant varieties',
                    'Proper water management',
                    'Avoid excessive nitrogen fertilization',
                    'Biological control with spiders and parasitoids',
                    'Targeted insecticide application'
                ],
                'insecticide_recommendations' => [
                    'Imidacloprid 17.8 SL @ 0.3 ml/L',
                    'Buprofezin 25 SC @ 2 ml/L',
                    'Clothianidin 50 WDG @ 0.3 g/L'
                ],
                'environmental_factors' => [
                    'High humidity favors development',
                    'Temperature range 25-30°C optimal',
                    'Dense planting increases infestation'
                ]
            ],
            [
                'name' => 'Fall Armyworm',
                'scientific_name' => 'Spodoptera frugiperda',
                'type' => 'pest',
                'description' => 'An invasive pest that attacks various crops including corn, rice, and vegetables.',
                'symptoms' => [
                    'Feeding damage on leaves creating "window panes"',
                    'Damage to growing point (whorl)',
                    'Presence of frass in whorl',
                    'Ragged holes in leaves'
                ],
                'control_methods' => [
                    'Early detection and monitoring',
                    'Pheromone traps',
                    'Egg mass destruction',
                    'Biological control with natural enemies',
                    'Targeted insecticide spray'
                ],
                'insecticide_recommendations' => [
                    'Emamectin benzoate 5 SG @ 0.4 g/L',
                    'Chlorantraniliprole 18.5 SC @ 0.3 ml/L',
                    'Spinetoram 11.7 SC @ 0.5 ml/L'
                ],
                'environmental_factors' => [
                    'Warm temperatures accelerate development',
                    'Can spread rapidly with wind',
                    'Multiple host plants available'
                ]
            ],
            [
                'name' => 'Rice Blast',
                'scientific_name' => 'Pyricularia oryzae',
                'type' => 'disease',
                'description' => 'A fungal disease that causes significant yield losses in rice production.',
                'symptoms' => [
                    'Diamond-shaped lesions on leaves',
                    'Gray center with brown borders',
                    'Neck rot causing panicle death',
                    'Node infection causing stem breakage'
                ],
                'control_methods' => [
                    'Use resistant varieties',
                    'Proper seed treatment',
                    'Balanced fertilization',
                    'Field sanitation',
                    'Fungicide application'
                ],
                'insecticide_recommendations' => [
                    'Tricyclazole 75 WP @ 0.6 g/L',
                    'Azoxystrobin 23 SC @ 1 ml/L',
                    'Isoprothiolane 40 EC @ 1.5 ml/L'
                ],
                'environmental_factors' => [
                    'High humidity and moderate temperature',
                    'Water stress favors infection',
                    'Dense canopy increases disease pressure'
                ]
            ],
            [
                'name' => 'Bacterial Wilt',
                'scientific_name' => 'Ralstonia solanacearum',
                'type' => 'disease',
                'description' => 'A bacterial disease affecting tomato, potato, and other solanaceous crops.',
                'symptoms' => [
                    'Sudden wilting of plants',
                    'Yellow lower leaves',
                    'Brown vascular discoloration',
                    'Bacterial ooze from cut stems'
                ],
                'control_methods' => [
                    'Use resistant varieties',
                    'Crop rotation with non-host plants',
                    'Soil solarization',
                    'Proper drainage',
                    'Avoid mechanical damage to roots'
                ],
                'insecticide_recommendations' => [
                    'Copper hydroxide 77 WP @ 2 g/L',
                    'Streptomycin sulfate 9% + Tetracycline 1% @ 0.5 g/L',
                    'Bordeaux mixture @ 1%'
                ],
                'environmental_factors' => [
                    'High soil moisture and temperature',
                    'Soil pH between 6.0-7.0 favors disease',
                    'Poor drainage increases incidence'
                ]
            ],
            [
                'name' => 'Aphids',
                'scientific_name' => 'Various species',
                'type' => 'pest',
                'description' => 'Small sap-sucking insects that attack a wide range of crops.',
                'symptoms' => [
                    'Curled and yellowing leaves',
                    'Stunted plant growth',
                    'Honeydew deposits',
                    'Sooty mold development',
                    'Transmission of viral diseases'
                ],
                'control_methods' => [
                    'Regular monitoring',
                    'Natural predators conservation',
                    'Reflective mulch',
                    'Neem-based products',
                    'Selective insecticides'
                ],
                'insecticide_recommendations' => [
                    'Imidacloprid 200 SL @ 0.3 ml/L',
                    'Acetamiprid 20 SP @ 0.2 g/L',
                    'Neem oil @ 5 ml/L'
                ],
                'environmental_factors' => [
                    'Cool weather favors population growth',
                    'Water stress increases susceptibility',
                    'Over-fertilization with nitrogen'
                ]
            ],
            [
                'name' => 'Coffee Berry Borer',
                'scientific_name' => 'Hypothenemus hampei',
                'type' => 'pest',
                'description' => 'A major pest of coffee that bores into coffee berries.',
                'symptoms' => [
                    'Small holes in coffee berries',
                    'Premature berry drop',
                    'Reduced coffee quality',
                    'Presence of bore dust'
                ],
                'control_methods' => [
                    'Timely harvesting',
                    'Field sanitation',
                    'Pheromone traps',
                    'Biological control agents',
                    'Targeted insecticide application'
                ],
                'insecticide_recommendations' => [
                    'Endosulfan 35 EC @ 2 ml/L',
                    'Chlorpyrifos 20 EC @ 2 ml/L'
                ],
                'environmental_factors' => [
                    'High altitude and moderate temperature',
                    'High humidity favors development',
                    'Presence of mature berries'
                ]
            ]
        ];

        foreach ($pests as $pestData) {
            // Get commodity IDs for affected commodities
            if (str_contains(strtolower($pestData['name']), 'rice') || str_contains(strtolower($pestData['name']), 'planthopper')) {
                $rice = Commodity::where('name', 'Rice')->first();
                $pestData['affected_commodities'] = $rice ? [$rice->id] : [];
            } elseif (str_contains(strtolower($pestData['name']), 'fall armyworm')) {
                $corn = Commodity::where('name', 'Corn')->first();
                $rice = Commodity::where('name', 'Rice')->first();
                $commodityIds = [];
                if ($corn) $commodityIds[] = $corn->id;
                if ($rice) $commodityIds[] = $rice->id;
                $pestData['affected_commodities'] = $commodityIds;
            } elseif (str_contains(strtolower($pestData['name']), 'bacterial wilt')) {
                $tomato = Commodity::where('name', 'Tomato')->first();
                $pestData['affected_commodities'] = $tomato ? [$tomato->id] : [];
            } elseif (str_contains(strtolower($pestData['name']), 'coffee')) {
                $coffee = Commodity::where('name', 'Coffee')->first();
                $pestData['affected_commodities'] = $coffee ? [$coffee->id] : [];
            } else {
                // Aphids affect multiple crops
                $commodityIds = Commodity::take(3)->pluck('id')->toArray();
                $pestData['affected_commodities'] = $commodityIds;
            }

            Pest::create($pestData);
        }
    }
}