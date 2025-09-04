<?php

namespace App\Services\UDS;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BonusApi {
    private const UDS_BASE_URL = 'https://api.uds.app/partner/v2/';

    public function getClient(Request $request) {
        return $this->sendRequest('customers/find?code=' . $request->code, 'GET');
    }

    public function createOperation(Request $request) {
        $calcOperation = $this->calcCashOperation($request);

        if (isset($calcOperation->purchase)) {
            $data = [
                'code' => $request->code,
                'cashier' => [
                    'externalId' => 'AmoCRM',
                    'name' => 'Интеграция с AmoCRM'
                ],
                'receipt' => array(
                    'total' => $request->total,
                    'points' => $calcOperation->purchase->points,
                    'cash' => $calcOperation->purchase->cash,
                    'number' => $request->lead_id
                )
            ];

            return $this->sendRequest('operations', data: $data);
        }

        return $calcOperation;
    }

    public function reward(Request $request) {
        $data = [
            'code' => $request->code,
            'nonce' => (string) Str::uuid(),
            'cashier' => [
                'externalId' => 'AmoCRM',
                'name' => 'Интеграция с AmoCRM'
            ],
            'receipt' => [
                'total' => $request->total,
                'points' => 0,
                'cash' => $request->total,
                'number' => $request->lead_id
            ]
        ];

        return $this->sendRequest('operations', data: $data);
    }

    public function calcCashOperation(Request $request) {
        $data = [
            'code' => $request->code,
            'receipt' => array(
                'total' => $request->total
            )
        ];

        return $this->sendRequest('operations/calc', data: $data);
    }

    private function sendRequest($endpoint, $method = 'POST', $data = null) {
        $strAuth = config('uds.id') . ':' . config('uds.apiKey');

        $date = new DateTime();
        $header = [
            'Accept: application/json',
            'Accept-Charset: utf-8',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($strAuth),
            'X-Origin-Request-Id: ' . time(),
            'X-Timestamp: ' . $date->format(DateTime::ATOM)
        ];

        $curlOpt = [
            CURLOPT_URL => self::UDS_BASE_URL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $header,
        ];

        if ($method === 'POST') {
            $curlOpt[CURLOPT_POST] = 1;
            $curlOpt[CURLOPT_CUSTOMREQUEST] = 'POST';
            $curlOpt[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curlOpt);

        $res = curl_exec($ch);
        return json_decode($res);
    }
}
