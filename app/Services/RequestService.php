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

    public function get($url, $params = [], $headers = [])
    {
        try {
            $get = $this->client->get($url, [
                'headers' => $headers,
            ]);
            return $get;
        } catch (\Throwable $th) {
            TelegramService::sendMessage($th->getMessage());
        }

        return false;
    }

    public function post($url, $params = [], $headers = [])
    {
        try {
            $send = $this->client->request('POST', $url, [
                'headers' => $headers, 'body' => $params
            ]);

            return $send;
        } catch (\Throwable $th) {
            TelegramService::sendMessage($th->getMessage());
        }

        return false;
    }

    private function newClient()
    {
        return new Client([
            'timeout' => 5,
            'cookies' => true,
            'http_errors' => false,
            'verify' => false
        ]);
    }
}
