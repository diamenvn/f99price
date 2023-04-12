<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CrawlSiteJob;
use App\Services\ConfigService;
use App\Services\SyncSiteService;
use App\Services\ApiService;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiConfigController extends Controller
{
    protected $configService;
    public function __construct(ConfigService $configService, SyncSiteService $syncPageService, ApiService $apiService)
    {
        $this->configService = $configService;
        $this->syncPageService = $syncPageService;
        $this->apiService = $apiService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function getAll()
    {
        $get = $this->configService->search([], ['created_at' => 'DESC']);
        foreach ($get as $key => $value) {
            $value['status'] = [
                'type' =>  $value['status'],
                'msg' => $value['status'] == 1 ? "Đang hoạt động" : ($value['status'] == 0 ? "Đang tạm dừng" : "Lỗi xác thực username")
            ];
        }
        $this->response['success'] = true;
        $this->response['msg'] = "Hoàn thành";
        $this->response['data'] = $get;
        return response()->json($this->response);
    }

    public function checkConnection()
    {
        $syncSites = $this->syncPageService->getLastRowCheckConnectionByLimit(2);
        foreach ($syncSites as $site) {
            $push = $this->apiService->checkConnectWordpressByAccessToken($site->domain, $site->base64_authenticate);
            $status = $site->status;
            if (!$push) {
                $this->configService->updateBySyncSiteId($site->_id, ['status' => 2]);
                TelegramService::sendMessage("Site <b>" . $site->domain . "</b> mất kết nối");
            }

            $this->syncPageService->update($site, [
                'last_check_connection' => Carbon::now()->addMinute(60)
            ]);
        }
        


        $this->response['success'] = true;
        $this->response['msg'] = "Hoàn thành";
        $this->response['data'] = [];
        return response()->json($this->response);
    }
}
