<?php

namespace App\Services;

use App\Models\City;
use App\Models\Market;
use App\Services\Helpers;
use Illuminate\Http\Request;

class CitiesService {
    public static function getCity() {
        if (session()->has('city_id')) {
            $city_id = session('city_id');
            if (is_numeric($city_id)) {
                $city = cache('city_' . $city_id, function () use ($city_id) {
                    return City::where('id', $city_id)->first();
                });
                if ($city) return $city;
            }
        }

        $cityIdFromUrl = request()->query('city');
        if ($cityIdFromUrl && is_numeric($cityIdFromUrl)) {
            $city = City::find($cityIdFromUrl);
            if ($city) {
                cookie()->queue(cookie()->forever('city_id', $city->id));
                return $city;
            }
        }

        if (request()->hasCookie('city_id')) {
            $city_id = request()->cookie('city_id');
            if (is_numeric($city_id)) {
                $city = cache('city_' . $city_id, function () use ($city_id) {
                    return City::where('id', $city_id)->first();
                });
                if ($city) return $city;
            }
        }

        $city = cache('city_first', function () {
            return City::active()->first() ?? City::first();
        });

        cookie()->queue(cookie()->forever('city_id', $city->id));

        return $city;
    }

    public static function DateTime() {
        $utc = str_replace('UTC', '', self::getCity()->timezone);
        $utc = (int) $utc;
        $original = new \DateTime("now", new \DateTimeZone('UTC'));
        $timezoneName = timezone_name_from_abbr("", $utc * 3600, false);
        $modified = $original->setTimezone(new \DateTimezone($timezoneName));
        return $modified;
    }

    public static function getActiveCities() {
        return City::active()->take(24)->get();
    }

    public function filter($name) {
        $name = Helpers::changeKeymap(mb_strtolower($name));
        return City::active()->where('city', 'ilike', $name . '%')->get();
    }
}
