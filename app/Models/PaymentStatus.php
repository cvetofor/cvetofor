<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class PaymentStatus extends Model implements Sortable
{
    use HasPosition;

    public const PAID = 'PA';

    public const AWAIT = 'WA';

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'code',
    ];
}
