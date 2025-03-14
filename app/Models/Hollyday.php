<?php

namespace App\Models;


use A17\Twill\Models\Model;
use App\Services\CitiesService;

class Hollyday extends Model
{
    protected $dates = [
        'begin_at',
        'end_at',
    ];

    protected $fillable = [
        'published',
        'title',
        'description',
        'begin_at',
        'end_at',
    ];

    public static function isHollyDays()
    {
        return \Cache::remember(
            'isHollyDays_' . CitiesService::getCity()->id,
            360,
            function () {
                $date = \Carbon\Carbon::create(CitiesService::DateTime());

                $isHollyDays = Hollyday::published()
                    ->whereMonth('begin_at', '<=', $date->month)
                    ->whereMonth('end_at', '>=', $date->month)
                    ->whereDay('end_at', '>=', $date->day)
                    ->exists();

                $hollydays = Hollyday::published()
                    ->whereMonth('begin_at', '<=', $date->month)
                    ->whereMonth('end_at', '>=', $date->month)
                    ->whereDay('end_at', '>=', $date->day)
                    ->get();

                foreach ($hollydays as $key => $hollyday) {
                    if ($hollyday->begin_at->month == $date->month && $hollyday->begin_at->day <= $date->day) {
                        $isHollyDays = true;
                    } else if ($hollyday->begin_at->month == $date->month && $hollyday->begin_at->day >= $date->day) {
                        $isHollyDays = false;
                    }
                }
                return $isHollyDays;
            }
        );
    }

}
