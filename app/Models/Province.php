<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Province
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $latitude
 * @property string|null $longitude
 * @property array|null $boundaries
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Regency[] $regencies
 * @property-read int|null $regencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommodityDistribution[] $commodityDistributions
 * @property-read int|null $commodity_distributions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereBoundaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Province extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
     * Get the regencies for the province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }

    /**
     * Get the commodity distributions for the province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commodityDistributions(): HasMany
    {
        return $this->hasMany(CommodityDistribution::class);
    }
}