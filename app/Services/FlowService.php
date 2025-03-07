<?php

namespace App\Services;

use GuzzleHttp\Client;

class FlowService
{
    protected $client;
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FLOW_API_KEY');
        $this->secretKey = env('FLOW_SECRET_KEY');
        $this->baseUrl = env('FLOW_BASE_URL');
    }

    private function signParams($params)
    {
        ksort($params);
        $stringToSign = http_build_query($params);
        return hash_hmac('sha256', $stringToSign, $this->secretKey);
    }

    public function createPayment($data)
    {
        $url = $this->baseUrl . '/payment/create';
        $params = [
            'apiKey' => $this->apiKey,
            'commerceOrder' => $data['commerceOrder'],
            'subject' => $data['subject'],
            'amount' => $data['amount'],
            'email' => $data['email'],
            'urlConfirmation' => $data['urlConfirmation'],
            'urlReturn' => $data['urlReturn'],
        ];
        $params['s'] = $this->signParams($params);

        $response = $this->client->post($url, ['form_params' => $params]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
