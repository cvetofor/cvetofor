<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DateInterval extends Model
{
    protected $fillable = [
        'market_id',
        'name_date_interval_id',
        'date',
        'start_time',
        'end_time',
        'close_time',
        'close_time_behavior',
    ];

    public function getStartTimeAttribute($value)
    {
        return $this->minutesToTime($value);
    }

    public function getEndTimeAttribute($value)
    {
        return $this->minutesToTime($value);
    }

    public function getCloseTimeAttribute($value)
    {
        return $this->minutesToTime($value);
    }

    /**
     * Проверяет доступность интервала на основе текущего времени.
     */
    public function isAvailable(Carbon $currentTime): bool
    {
        if ($this->close_time < 0) {
            throw new \InvalidArgumentException('Close time cannot be negative.');
        }

        $startTimeInMinutes = $this->start_time % 1440; // Защита от превышения границ суток
        $closeTimeInMinutes = $this->close_time_behavior === 'before'
            ? $startTimeInMinutes - $this->close_time
            : $startTimeInMinutes + $this->close_time;

        $closeTime = Carbon::createFromTime(
            floor(($closeTimeInMinutes % 1440) / 60),
            $closeTimeInMinutes % 60
        );

        return $currentTime->lessThan($closeTime);
    }

    /**
     * Преобразует количество минут в строку времени (H:i).
     */
    private function minutesToTime(int $minutes): string
    {
        $hours = floor(($minutes % 1440) / 60); // Учёт 1440 минут в сутках
        $minutes = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Связь с моделью Market.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * Преобразует интервал в строку времени (например, "с 00:00 до 23:00").
     */
    public function formatInterval(): string
    {
        if ($this->start_time >= $this->end_time) {
            return 'Некорректный интервал времени';
        }

        $startFormatted = $this->minutesToTime($this->start_time);
        $endFormatted = $this->minutesToTime($this->end_time);

        return "с {$startFormatted} до {$endFormatted}";
    }
}
