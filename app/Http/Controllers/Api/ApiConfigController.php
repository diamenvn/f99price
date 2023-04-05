<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CrawlSiteJob;
use App\Services\ConfigService;
use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    protected $configService;
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
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
}
