<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;
use Illuminate\Http\Request;

class CityFromQueryString
{
    public function handle(Request $request, Closure $next)
    {
        $cityId = $request->query('city');

        if ($cityId && is_numeric($cityId)) {
            $city = City::find($cityId);

            if ($city) {
                session(['city_id' => $city->id]);
                cookie()->queue(cookie()->forever('city_id', $city->id));
            }
        }

        if ($request->has('bot_name')) {
            $botName = $request->get('bot_name');
            session(['bot_name' => $botName]);
            cookie()->queue(cookie()->forever('bot_name', $botName));
        }

        return $next($request);
    }
}
