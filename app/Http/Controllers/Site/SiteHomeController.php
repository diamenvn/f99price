<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\LogService;
use App\Services\CrawlSiteService;
use App\Services\SyncSiteService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteHomeController extends Controller
{
    public function __construct(PostService $postService, LogService $logService, CrawlSiteService $crawlSiteService, SyncSiteService $syncSiteService)
    {
        $this->postService = $postService;
        $this->logService = $logService;
        $this->crawlSiteService = $crawlSiteService;
        $this->syncSiteService = $syncSiteService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function index()
    {
        return redirect()->route('site.home.dashboard');
    }

    public function dashboard(Request $request)
    {
        $data['count_today'] = $this->postService->countByIDWithStartDateEndDate(null, Carbon::now()->startOfDay(), Carbon::now()->endOfDay());
        $data['count_synced'] = $this->sumByField($this->logService->getByCondition([]), "count_post_sync_success");
        $data['count_month'] = $this->postService->countByIDWithStartDateEndDate(null, Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $data['count_total'] = $this->postService->countByIDWithStartDateEndDate(null);
        $data['sidebarRight'] = "d-none";
        $data['title'] = "Thống kê";

        $data['charts'] = $this->crawlSiteService->getByCondition([], ['crawled_last_time' => 'DESC'])->load('config.log')->take(5);
        $data['recentSync'] = $this->syncSiteService->getByCondition([], ['crawled_last_time' => 'DESC'])->load('config.log')->take(5);
        foreach ($data['charts'] as $key => $value) {
            $data['charts'][$key]['count'] = $this->postService->countByIDWithStartDateEndDate($value->_id);
        }
        return view('site.dashboard.index', $data);
    }

    public function sumByField($rows, $field) 
    {
        return array_sum(array_keys($rows->keyBy($field)->toArray()));
    }
}
