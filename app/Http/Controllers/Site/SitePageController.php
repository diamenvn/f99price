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
        $domain = $request->domain ?? null;

        if (!$domain) {
            $this->response['msg'] = "Domain không được bỏ trống";
            return response()->json($this->response);
        }

        $insert['domain'] = $domain;
        $insert['status'] = 1;

        $this->crawlSiteService->create($insert);

        return view('site.page.form');
    }
    
    public function edit($siteId)
    {
        $data['detail'] = $this->crawlSiteService->firstById($siteId);
        return view('site.page.form', $data);
    }

}
