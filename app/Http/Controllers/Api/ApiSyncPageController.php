<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SyncSiteService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiSyncPageController extends Controller
{
    protected $syncPageService;
    public function __construct(SyncSiteService $syncPageService)
    {
        $this->syncPageService = $syncPageService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function getAll(Request $request)
    {
        $rows = $this->syncPageService->search([], ['created_at' => 'DESC']);
        foreach ($rows as $row) {
            $row['count'] = 0;
            foreach ($row->config as $config) {
                $row['count'] += $config->log->count_post_sync_success;
            }
        }
        $this->response['success'] = true;
        $this->response['msg'] = "Hoàn thành";
        $this->response['data'] = $rows;
        return response()->json($this->response);
    }
}
