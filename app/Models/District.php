<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\District
 *
 * @property int $id
 * @property int $regency_id
 * @property string $name
 * @property string $code
 * @property string|null $latitude
 * @property string|null $longitude
 * @property array|null $boundaries
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Regency $regency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommodityDistribution[] $commodityDistributions
 * @property-read int|null $commodity_distributions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereRegencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereBoundaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'regency_id',
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
     * Get the regency that owns the district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the commodity distributions for the district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commodityDistributions(): HasMany
    {
        return $this->hasMany(CommodityDistribution::class);
    }
}