<?php

namespace App\Models;

use A17\Twill\Models\Model;

class Tag extends Model
{
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_category_limited && $model->limit_start_date && $model->limit_end_date) {
                if ($model->limit_end_date <= $model->limit_start_date) {
                    throw new \Exception('Дата окончания должна быть позже даты начала.');
                }
            }
        });
    }

    public function scopeAvailable($query)
    {
        return $query->where(function ($q) {
            $today = now()->toDateString();
            $q->where('is_category_limited', false)
                ->orWhere(function ($q2) use ($today) {
                    $q2->where('limit_start_date', '<=', $today)
                        ->where('limit_end_date', '>=', $today);
                });
        });
    }

    public function isAvailable(): bool
    {
        if (! $this->is_category_limited) {
            return true; // Если ограничение не включено, категория доступна всегда
        }

        $today = now()->toDateString();

        return $this->limit_start_date <= $today && $this->limit_end_date >= $today;
    }

    protected $fillable = [
        'name',
        'slug',
        'is_category_limited',
        'limit_start_date',
        'limit_end_date',
    ];
}
