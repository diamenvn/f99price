<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CrawlSiteJob;
use App\Services\PostService;
use Illuminate\Http\Request;

class ApiPageController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function getAllPost(Request $request)
    {
        $request = $request->only(['site_id']);
        $siteId = $request['site_id'] ?? null;
        if (!isset($siteId)) {
            $this->response['msg'] = "id can't empty!";
            return response()->json($this->response, 500);
        }

        $get = $this->postService->search(['site_id' => $siteId], ['post_date' => 'DESC']);
        $this->response['success'] = true;
        $this->response['msg'] = "Hoàn thành";
        $this->response['data'] = $get;
        return response()->json($this->response);
    }
}
