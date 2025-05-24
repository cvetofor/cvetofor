<?php

namespace App\Models;

use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class Profile extends Model
{
    protected $fillable = [
        'published',
        'name',
        'second_name',
        'last_name',
        'email',
        'phone',
        'concent_exclusive_email',
        'password',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getTitleAttribute()
    {
        return $this->user?->last_name ?? ''.' '.$this->user?->name ?? ''.' '.$this->user?->second_name ?? '';
    }

    public function setNameAttribute($value)
    {
        $this->user->name = $value;
        $this->user->save();
    }

    public function orders()
    {
        return $this->user->orders();
    }

    public function getSecondNameAttribute()
    {
        return $this->user->second_name;
    }

    public function setSecondNameAttribute($value)
    {
        $this->user->second_name = $value;
        $this->user->save();
    }

    public function getLastNameAttribute()
    {
        return $this->user->last_name;
    }

    public function setLastNameAttribute($value)
    {
        $this->user->last_name = $value;
        $this->user->save();
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function setEmailAttribute($value)
    {
        $this->user->email = $value;
        $this->user->save();
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    public function setPhoneAttribute($value)
    {
        $this->user->phone = str_replace(['(', ')', '-', ' '], ['', '', '', ''], $value);
        $this->user->save();
    }

    public function getConcentExclusiveEmailAttribute()
    {
        return $this->user->concent_exclusive_email;
    }

    public function setConcentExclusiveEmailAttribute($value)
    {
        $this->user->concent_exclusive_email = $value;
        $this->user->save();
    }

    public function setPasswordAttribute($value)
    {
        $this->user->password = Hash::make($value);
        $this->user->save();
    }
}
