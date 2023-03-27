<?php

namespace App\Services;
use App\Services\RequestService;

class ApiService
{
    CONST F99_API_URL = "https://f99apim.azure-api.net/catalog/v2/api/Service/products";
    CONST SUBCRIPTION_KEY = "b03c9f82fb0e4926904b5b36070bc39d";

    public function __construct()
    {
        
    }

    public function getDataApiF99()
    {
        $params = ['Location' => 'b4bb3e8f-8f73-4f3a-8ea9-7d95147bcc68'];
        $headers = ['Ocp-Apim-Subscription-Key' => self::SUBCRIPTION_KEY];

        $request = new RequestService();
        $get = $request->get(self::F99_API_URL, $params, $headers);
        if ($get->getStatusCode() == 200) {
            return $get->getBody()->getContents();
        }
    }
}
