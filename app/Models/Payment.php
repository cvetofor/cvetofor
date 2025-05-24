<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class Payment extends Model implements Sortable
{
    use HasMedias, HasPosition, HasPosition;

    protected $fillable = [
        'published',
        'name',
        'code',
        'position',
        'vat',
        'tax_system_code',
    ];

    public const ACCOUNT = 'account';

    public const CASH = 'cash';

    public const ROBOKASSA = 'robokassa';

    public const YOOKASSA = 'yookassa';

    public $mediasParams = [
        'logo' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
        ],
    ];
}
