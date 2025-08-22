<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Commodity
 *
 * @property int $id
 * @property string $name
 * @property string|null $scientific_name
 * @property string|null $description
 * @property string $category
 * @property string|null $image_url
 * @property array|null $growing_conditions
 * @property array|null $harvest_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Variety[] $varieties
 * @property-read int|null $varieties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommodityDistribution[] $distributions
 * @property-read int|null $distributions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereGrowingConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereHarvestInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereScientificName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commodity whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Commodity extends Model
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
        'description',
        'category',
        'image_url',
        'growing_conditions',
        'harvest_info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'growing_conditions' => 'array',
        'harvest_info' => 'array',
    ];

    /**
     * Get the varieties for the commodity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function varieties(): HasMany
    {
        return $this->hasMany(Variety::class);
    }

    /**
     * Get the distributions for the commodity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function distributions(): HasMany
    {
        return $this->hasMany(CommodityDistribution::class);
    }
}