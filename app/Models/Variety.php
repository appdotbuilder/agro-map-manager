<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Variety
 *
 * @property int $id
 * @property int $commodity_id
 * @property string $name
 * @property string|null $description
 * @property array|null $agronomic_traits
 * @property array|null $pest_susceptibility
 * @property int|null $maturity_days
 * @property string|null $potential_yield
 * @property string $yield_unit
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Commodity $commodity
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Variety newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variety newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variety query()
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereAgronomicTraits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereMaturityDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety wherePestSusceptibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety wherePotentialYield($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variety whereYieldUnit($value)

 * 
 * @mixin \Eloquent
 */
class Variety extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'commodity_id',
        'name',
        'description',
        'agronomic_traits',
        'pest_susceptibility',
        'maturity_days',
        'potential_yield',
        'yield_unit',
        'image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agronomic_traits' => 'array',
        'pest_susceptibility' => 'array',
        'potential_yield' => 'decimal:2',
    ];

    /**
     * Get the commodity that owns the variety.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }
}