<?php

namespace App\Services\UDS;

use DateTime;

class Bonus {
    private const UDS_BASE_URL = 'https://api.uds.app/partner/v2';

    public function getClient($code) {
        return $this->sendRequest('customers/find?code=' . $code, 'GET');
    }

    public function createOperation($code, $total) {
        $calcOperation = $this->calcCashOperation($code, $total);

        if (isset($calcOperation->purchase)) {
            $data = [
                'code' => $code,
                'receipt' => array(
                    'total' => $total,
                    'points' => $calcOperation->purchase->points,
                    'cash' => $calcOperation->purchase->cash
                )
            ];

            return $this->sendRequest('operations', data: $data);
        }

        return $calcOperation;
    }

    public function reward($code, $total) {
        $client = $this->getClient($code);
        if (isset($client->user->participant)) {
            $points = $total * ($client->user->participant->membershipTier->rate / 100);

            $data = [
                'points' => $points,
                'participants' => [$client->user->participant->id]
            ];

            return $this->sendRequest('operations/reward', data: $data);
        }

        return "nothing..";
    }

    public function calcCashOperation($code, $total) {
        $data = [
            'code' => $code,
            'receipt' => array(
                'total' => $total
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
            CURLOPT_URL => self::UDS_BASE_URL . '/' . $endpoint,
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
