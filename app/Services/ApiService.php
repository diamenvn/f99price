<?php

namespace App\Services;
use App\Services\RequestService;

class ApiService
{
    CONST PATH = "/wp-json/wp/v2/users?context=edit";
    CONST NEW_POST_PATH = "/wp-json/wp/v2/posts";
    CONST F99_API_URL = "b03c9f82fb0e4926904b5b36070bc39d";

    public function __construct()
    {
        
    }

    public function getDataApiF99()
    {
        $params = ['Location' => 'b4bb3e8f-8f73-4f3a-8ea9-7d95147bcc68'];
        $headers = [
            'Authorization' => 'Basic ' . $base64
        ];

        $request = new RequestService();
        $get = $request->get(self::F99_API_URL, $params, $headers);
        if ($get->getStatusCode() == 200) {
            return $get->getBody()->getContents();
        }
    }

    public function checkConnectWordpressByUserNameAndPassword($domain, $username, $password)
    {
        $headers = [
            'Authorization' => 'Basic ' . base64_encode($username . ':' . $password)
        ];

        $request = new RequestService();
        $get = $request->get($domain . self::PATH, [], $headers);
        return ($get->getStatusCode() >= 200 && $get->getStatusCode() < 300) == 200 ? true : false;
    }

    public function checkConnectWordpressByAccessToken($domain, $author)
    {
        $headers = [
            'Authorization' => 'Basic ' . $author,
            'Content-type'  => "application/json",
        ];

        $request = new RequestService();
        $get = $request->get($domain . self::PATH, [], $headers);
        return ($get->getStatusCode() >= 200 && $get->getStatusCode() < 300) == 200 ? true : false;
    }

    public function syncContent($domain, $params, $author)
    {
        $headers = [
            'Authorization' => 'Basic ' . $author,
            'Content-type'  => "application/json",
        ];

        $request = new RequestService();
        $get = $request->post($domain . self::NEW_POST_PATH, $params, $headers);

        if ($get->getStatusCode() >= 200 && $get->getStatusCode() < 300) {
            return $get->getBody()->getContents();
        }

        return false;
    }
}
