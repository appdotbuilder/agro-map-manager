<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pest
 *
 * @property int $id
 * @property string $name
 * @property string|null $scientific_name
 * @property string $type
 * @property string|null $description
 * @property array|null $symptoms
 * @property array|null $affected_commodities
 * @property array|null $control_methods
 * @property array|null $insecticide_recommendations
 * @property string|null $image_url
 * @property array|null $environmental_factors
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Pest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereAffectedCommodities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereControlMethods($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereEnvironmentalFactors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereInsecticideRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereScientificName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereSymptoms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pest whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Pest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'scientific_name',
        'type',
        'description',
        'symptoms',
        'affected_commodities',
        'control_methods',
        'insecticide_recommendations',
        'image_url',
        'environmental_factors',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'symptoms' => 'array',
        'affected_commodities' => 'array',
        'control_methods' => 'array',
        'insecticide_recommendations' => 'array',
        'environmental_factors' => 'array',
    ];
}