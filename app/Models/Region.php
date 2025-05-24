<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasPosition;

    protected $fillable = [
        'published',
        'position',
        'name',
        'type',
        'name_with_type',
        'federal_district',
        'kladr_id',
        'fias_id',
        'okato',
        'oktmo',
        'tax_office',
        'postal_code',
        'iso_code',
        'timezone',
        'geoname_code',
        'geoname_id',
        'geoname_name',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'region_id')->orderBy('position');
    }
}
