<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CrawlJob;
use App\Services\ApiService;

class ApiCrawlController extends Controller
{
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function start()
    {
        CrawlJob::dispatch();
        $this->response['success'] = true;
        $this->response['msg'] = "Hoàn thành";
        return response()->json($this->response);
    }

    public function FetchApiF99()
    {
        return $this->apiService->getDataApiF99();
    }
}
