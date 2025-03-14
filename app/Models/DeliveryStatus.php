<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class DeliveryStatus extends Model implements Sortable
{
    use HasPosition;

    //Передан курьеру
    public const TRANSFERRED = 'HC';

    // Доставлен
    public const DELIVERED = 'DE';

    // Не доставлен
    public const UN_DELIVERED = 'UD';

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'code',
    ];

}
