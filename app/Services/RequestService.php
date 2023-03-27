<?php

namespace App\Services;

use App\Helpers\Helper;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class RequestService
{
    public function __construct()
    {
        $this->client = $this->newClient();
    }

    public function get($url, $params = [], $header = [])
    {
        try {
            $get = $this->client->get($url . "?" . http_build_query($params), [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => 'b03c9f82fb0e4926904b5b36070bc39d'
                ],
            ]);
            return $get;
        } catch (\Throwable $th) {
            TelegramService::sendMessage($th->getMessage());
        }

        return false;
    }

    private function newClient()
    {
        return new Client([
            'timeout' => 30,
            'cookies' => true,
            'http_errors' => false
        ]);
    }
}
