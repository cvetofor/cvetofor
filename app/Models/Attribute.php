<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasRevisions;

    protected $fillable = [
        'label',
        'variable_generated_at',
        'product_id',
        'values',
    ];

    protected $casts = [
        'values' => 'array',
        'variable_generated_at' => 'datetime'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
