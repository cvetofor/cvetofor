<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Services\CitiesService;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function setCity($city_id, Request $request)
    {
        $cityModel = cache('city_'.$city_id, function () use ($city_id) {
            return City::where('id', $city_id)->first();
        });

        if ($cityModel) {
            \Session::put('timezone', $cityModel->timezone);
        }

        return response()->json([
            'id' => $cityModel->id,
            'name' => $cityModel->city,
        ])->withCookie(cookie()->forever('city_id', $cityModel->id, null, null, null, false));
    }

    public function filter($name, CitiesService $citiesService)
    {
        return CityResource::collection($citiesService->filter($name));
    }
}
