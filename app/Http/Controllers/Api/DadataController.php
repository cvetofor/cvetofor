<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Services\CitiesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DadataController extends Controller
{

    public $api = '5e92644e9396e1985e27534dd409a1fabb19904b';

    public function search()
    {


        $client = new Client();

        $response = $client->post(
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Token ' . $this->api,
                ],
                'json' => [
                    'query' => request('q'),
                ],
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);
        $datareturn = [];
        foreach ($data['suggestions'] ?? [] as $suggestion) {
            $datareturn[] = [
                'value' => $suggestion['value'],
            ];
        }
        return $datareturn;


    }
}
