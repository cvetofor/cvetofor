<?php

namespace App\Models;

use A17\Twill\Models\Model;
use Illuminate\Support\Collection;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasTranslation;
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
