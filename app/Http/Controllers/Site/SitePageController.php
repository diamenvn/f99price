<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SitePageController extends Controller
{
    public function __construct(BrandService $brandService, ResultService $resultService)
    {
        $this->brandService = $brandService;
        $this->resultService = $resultService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function index()
    {
        $data['sidebarRight'] = "";
        return view('site.page.index', $data);
    }

    public function dashboard(Request $request)
    {
        $brandId = $request->input('brand_id', null);
        $results = array();
        if (isset($brandId)) {
            $data['brand'] = $this->brandService->firstById($brandId);
            $day = $request["day"] ?? 7;
            $day = (int)$day;

            for ($i = 0; $i < $day; $i++) {
                $startDate = Carbon::now()->subDay($i)->startOfDay();
                $endDate = Carbon::now()->subDay($i)->endOfDay();


                $result['data'] = $this->resultService->getBetweenDate($brandId, $startDate, $endDate)->count();
                $result['date'] = Carbon::now()->subDay($i)->format("d/m/Y");
                array_push($results, $result);
            }
            $data['rows'] = $this->resultService->getByBrandId($brandId);
        }
        $data['title'] = "Trang chủ";
        $data['charts'] = array_reverse($results);
        $data['brands'] = $this->brandService->getByCondition(['status' => 1], ['created_at' => 'DESC'])->load('items');

        return view('site.dashboard.index', $data);
    }

    public function AddPage()
    {
        return view('site.sidebar.add_page');
    }

    public function storeAddPage(Request $request)
    {
        $request = $request->only(['brand_name', 'brand_url', 'brand_logo_url']);
        foreach ($request as $key => $value) {
            if ($key == 'brand_logo_url') continue;
            if (!isset($value) && empty($value)) {
                $this->response['msg'] = "params " . $key . " is require";
                return response()->json($this->response);
            }
        }

        $request['status'] = 1;
        $create = $this->brandService->create($request);
        if ($create) {
            $this->response['msg'] = "Thành công";
            $this->response['success'] = true;
            $this->response['data'] = $create;
        }

        return response()->json($this->response);
    }
}
