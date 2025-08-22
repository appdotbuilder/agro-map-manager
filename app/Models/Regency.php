<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Regency
 *
 * @property int $id
 * @property int $province_id
 * @property string $name
 * @property string $code
 * @property string|null $latitude
 * @property string|null $longitude
 * @property array|null $boundaries
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\District[] $districts
 * @property-read int|null $districts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommodityDistribution[] $commodityDistributions
 * @property-read int|null $commodity_distributions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Regency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereBoundaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regency whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Regency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'province_id',
        'name',
        'code',
        'latitude',
        'longitude',
        'boundaries',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'boundaries' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the province that owns the regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the districts for the regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * Get the commodity distributions for the regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commodityDistributions(): HasMany
    {
        return $this->hasMany(CommodityDistribution::class);
    }
}