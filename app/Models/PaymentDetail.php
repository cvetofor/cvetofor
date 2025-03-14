<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentDetail extends Model
{
    use HasRevisions;
    use HasRelated;

    protected $fillable = [
        'user_id',
        'approved',
        'fio',
        'legal_address',
        'postal_address',
        'inn',
        'kpp',
        'ogrn',
        'bank_fullname',
        'payment_account',
        'correspondent_account',
        'bik',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    function getPublishedAttribute()
    {
        return $this->approved;
    }

    function setPublishedAttribute($value)
    {
        $this->approved = $value;
    }
}
