<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CommodityDistribution
 *
 * @property int $id
 * @property int $commodity_id
 * @property int|null $province_id
 * @property int|null $regency_id
 * @property int|null $district_id
 * @property string|null $area_hectares
 * @property string|null $production_tons
 * @property string|null $productivity
 * @property int $year
 * @property array|null $environmental_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Commodity $commodity
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\Regency|null $regency
 * @property-read \App\Models\District|null $district
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereAreaHectares($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereEnvironmentalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereProductionTons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereProductivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereRegencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommodityDistribution whereYear($value)

 * 
 * @mixin \Eloquent
 */
class CommodityDistribution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'commodity_id',
        'province_id',
        'regency_id',
        'district_id',
        'area_hectares',
        'production_tons',
        'productivity',
        'year',
        'environmental_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'area_hectares' => 'decimal:2',
        'production_tons' => 'decimal:2',
        'productivity' => 'decimal:2',
        'environmental_data' => 'array',
    ];

    /**
     * Get the commodity that owns the distribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    /**
     * Get the province that owns the distribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the regency that owns the distribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the district that owns the distribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}