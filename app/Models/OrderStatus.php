<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class OrderStatus extends Model implements Sortable
{
    use HasPosition;

    /**
     * Подтверждён
     */
    public const CONFIRMED = 'CO';

    /**
     * Оформлен
     */
    public const ISSUED = 'DE';

    /**
     * В работе
     */
    public const WORK = 'IW';

    /**
     * Выполнен
     */
    public const COMPLETE = 'CM';

    /**
     * Отменён пользователем
     */
    public const CANCELED_USER = 'UN';

    /**
     * Отменён
     */
    public const CANCELED = 'AN';



    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'code',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_status_id');
    }

}
