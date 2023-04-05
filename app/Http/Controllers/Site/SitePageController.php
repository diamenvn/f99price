<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ResultService;
use App\Services\CrawlSiteService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SitePageController extends Controller
{
    public function __construct(
        BrandService $brandService, 
        ResultService $resultService, 
        CrawlSiteService $crawlSiteService,
        PostService $postService
    )
    {
        $this->brandService = $brandService;
        $this->resultService = $resultService;
        $this->crawlSiteService = $crawlSiteService;
        $this->postService = $postService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index(Request $request)
    {
        $siteId = $request->input('_id', null);

        $data['title'] = "Trang lấy dữ liệu";
        $data['crawls'] = $this->crawlSiteService->search(['status' => 1], ['created_at' => 'DESC']);
        // dd($data['crawls'][0]);
        $data['sidebarRight'] = "";
        $results = array();

        if (isset($siteId)) {
            $data['detail'] = $this->crawlSiteService->firstById($siteId);
            $data['posts'] = $this->postService->search(['site_id' => $siteId]);
            $data['today'] = $this->postService->countByIDWithStartDateEndDate($siteId, Carbon::now()->startOfDay(), Carbon::now()->endOfDay());
            $data['yesterday'] = $this->postService->countByIDWithStartDateEndDate($siteId, Carbon::now()->subDay(1)->startOfDay(), Carbon::now()->subDay(1)->endOfDay());
            $data['month'] = $this->postService->countByIDWithStartDateEndDate($siteId, Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
            $data['total'] = $this->postService->countByIDWithStartDateEndDate($siteId);
            $hour = $request["hour"] ?? 10;
            $hour = (int)$hour;
            
            for ($i = 0; $i < $hour; $i++) {
                $startDate = Carbon::now()->subHour($i)->startOfHour();
                $endDate = Carbon::now()->subHour($i)->endOfHour();

                $result['data'] = $this->postService->countByIDWithStartDateEndDate($siteId, $startDate, $endDate);
                $result['hour'] = Carbon::now()->subHour($i)->format("H");
                array_push($results, $result);
            }

        }
        $data['charts'] = array_reverse($results);
        return view('site.page.index', $data);
    }

    public function create()
    {
        return view('site.page.form');
    }

    public function store(Request $request)
    {
        $request = $request->only(['domain', 'limit_per_day', 'time_step']);
        $domain = $request['domain'] ?? null;

        if (!$domain) {
            $this->response['msg'] = "Domain không được bỏ trống";
            return response()->json($this->response);
        }

        $firstByDomain = $this->crawlSiteService->firstByCondition(['domain' => $domain]);
        if (isset($firstByDomain)) {
            $this->response['msg'] = "Domain này đã tồn tại";
            return response()->json($this->response);
        }

        $insert['domain'] = $domain;
        $insert['limit_per_day'] = $request['limit_per_day'] ?? config("app.limit_per_day");
        $insert['time_step'] = $request['time_step'] ?? config("app.time_step");
        $insert['status'] = 1;
        $insert['running'] = 0;
        $insert['crawled_last_time'] = Carbon::now();

        if ($this->crawlSiteService->create($insert)) {
            $this->response['success'] = true;
            $this->response['msg'] = "Tạo thành công";
        }

        return response()->json($this->response);
    }
    
    public function edit($siteId)
    {
        $data['detail'] = $this->crawlSiteService->firstById($siteId);
        return view('site.page.form', $data);
    }

    public function update(Request $request, $id)
    {
        $request = $request->only(['limit_per_day', 'time_step']);

        $firstByDomain = $this->crawlSiteService->firstById($id);
        if (!isset($firstByDomain)) {
            $this->response['msg'] = "Domain này không tồn tại";
            return response()->json($this->response);
        }

        $update['limit_per_day'] = $request['limit_per_day'] ?? config("app.limit_per_day");
        $update['time_step'] = $request['time_step'] ?? config("app.time_step");
        $update['status'] = 1;
        
        if ($this->crawlSiteService->update($firstByDomain, $update)) {
            $this->response['success'] = true;
            $this->response['msg'] = "Cập nhật thành công";
        }

        return response()->json($this->response);
    }

}
