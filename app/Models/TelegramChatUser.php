<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramChatUser extends Model
{
    protected $fillable = [
        'username',
        'chat_id',
        'bot',
    ];

    public $timestamps = false;

    public $autoincrement = false;

    public $incrementing = false;
}
