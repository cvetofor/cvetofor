<?php

namespace App\Http\Middleware;

use App\Models\City;
use App\Services\SxGeoService;
use Closure;
use Illuminate\Http\Request;

class GeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasCookie('city_id') || $request->has('city_id')) {

            $city_id = $request->get('city_id');

            $service = new SxGeoService(storage_path('sypex/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY));
            $city = $service->getCity($request->ip());
            $cityModel = null;

            if ($city && ! $request->has('city_id')) {

                $cityModel = cache('city_'.$city['city']['name_ru'], function () use ($city) {
                    return City::active()->where('address', 'like', '%г '.$city['city']['name_ru'])->first();
                });

            } elseif ($request->has('city_id')) {
                $cityModel = cache('city_'.$city_id, function () use ($city_id) {
                    return City::active()->where('id', $city_id)->first();
                });
            }
            if (! $cityModel) {
                $cityModel = cache('city_first', function () {
                    return City::active()->first();
                });
            }

            if ($cityModel) {
                \Session::put('timezone', $cityModel->timezone);
            }

            return $next($request)->withCookie(cookie()->forever('city_id', optional($cityModel)->id));
        }

        return $next($request);
    }
}
