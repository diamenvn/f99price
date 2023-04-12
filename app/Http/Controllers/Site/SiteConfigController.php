<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\SyncSiteService;
use App\Services\CrawlSiteService;
use App\Services\ConfigService;
use App\Services\LogService;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteConfigController extends Controller
{
    public function __construct(
        ConfigService $configService,
        SyncSiteService $syncSiteService,
        CrawlSiteService $crawlSiteService,
        ApiService $apiService,
        LogService $logService
    )
    {
        $this->configService = $configService;
        $this->syncSiteService = $syncSiteService;
        $this->crawlSiteService = $crawlSiteService;
        $this->apiService = $apiService;
        $this->logService = $logService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        $data['title'] = "Config";
        $data['rows'] = $this->syncSiteService->search(['status' => 1], ['created_at' => 'DESC']);
        $data['sidebarRight'] = "d-none";

        return view('site.config.index', $data);
    }

    public function create()
    {
        $data['crawl_sites'] = $this->crawlSiteService->getByCondition(['status' => 1], ['created_at' => 'DESC']);
        $data['sync_sites'] = $this->syncSiteService->getByCondition(['status' => 1], ['created_at' => 'DESC']);
        return view('site.config.form', $data);
    }

    public function store(Request $request)
    {
        $request = $request->only(['sync_site_id', 'crawl_site_id', 'time_step']);
        $request['time_step'] = (int)($request['time_step'] ?? config("app.sync_time_step"));
        $request['status'] = 1;
        $request['run_last_time'] = null;
        $request['run_next_time'] = Carbon::now()->addMinute($request['time_step']);

        $syncId = $request['sync_site_id'];
        $crawlId = $request['crawl_site_id'];

        if (isset($syncId) && isset($crawlId)) {
            $exist = $this->configService->isExistCrawlIdOrSyncId($crawlId, $syncId);
            if ($exist) {
                $this->response['msg'] = "Kết nối này đã tồn tại";
                return response()->json($this->response);
            }
        }
        $create = $this->configService->create($request);
        if ($create) {
            $create = $this->logService->create([
                'config_id' => $create->_id,
                'lasted_post_time' => Carbon::now(),
                'count_post_sync_success' => 0,
                'count_post_sync_error' => 0,
            ]);
            $this->response['success'] = true;
            $this->response['msg'] = "Hoàn thành";
            $this->response['data'] = $create;
        }

        return response()->json($this->response);
    }

    public function edit($id)
    {
        $data['detail'] = $this->configService->firstById($id);
        return view('site.config.form', $data);
    }

    public function update($id, Request $request)
    {
        $request = $request->only(['status', 'time_step']);
        $first = $this->configService->firstById($id);
        $request['status'] = (int)$request['status'];
        if ($first) {
            $update = $this->configService->update($first, $request);
            if ($update) {
                $this->response['success'] = true;
                $this->response['msg'] = "Cập nhật thành công";
                $this->response['data'] = $update;
            }
        }

        return response()->json($this->response);
    }

    public function destroy($id)
    {
        $first = $this->configService->firstById($id);
        if ($first) {
            $remove = $this->configService->remove($first);
            if ($remove) {
                $this->response['msg'] = "Xoá thành công";
                $this->response['success'] = true;
            }
        }

        return response()->json($this->response);
    }
}
