<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\ResultService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiCompareController extends Controller
{
    public function __construct(ResultService $resultService, ProductService $productService, BrandService $brandService)
    {
        $this->resultService = $resultService;
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
    }

    public function get()
    {
        $products = $this->productService->getByActive();
        $results = array();

        if (!$products) {
            $this->response['msg'] = "Empty product";
            return response()->json($this->response);
        }

        foreach ($products as $product) {
            $result = array();
            $params['name'] = $product->product_name;
            $result['product_name'] = $params['name'];
            
            $search = $this->resultService->search($params, ['created_at' => 'DESC']);
 
            if ($search) {
                foreach ($search as $item) {
                    $item->price = is_numeric($item->price) ? number_format($item->price) : $item->price;
                    if (isset($result[$item->brand_id])) {
                        array_push($result[$item->brand_id], $item);
                    }else{
                        $result[$item->brand_id] = array();
                        array_push($result[$item->brand_id], $item);
                    }
                }
                array_push($results, $result);
            }
        }

        $this->response['success'] = true;
        $this->response['msg'] = "Success";
        $this->response['data'] = $results;
        return response()->json($this->response);
    }

    public function detail(Request $request)
    {
        $request = $request->only(["name", "day"]);
        if (empty($request['name'])) {
            $this->response['msg'] = "Không tồn tại từ khoá cần tìm kiếm";
            return response()->json($this->response);
        }
        $day = $request["day"] ?? 7;
        $day = (int)$day;
        $results = array();
        $detail = null;

        for ($i=0; $i < $day; $i++) { 
            $startDate = Carbon::now()->subDay($i)->startOfDay();
            $endDate = Carbon::now()->subDay($i)->endOfDay();
            

            $result = $this->resultService->firstBetweenDate($request['name'], $startDate, $endDate);
            if ($result) {
                // $result['price'] = number_format($result['price']);
                $result['creation_time'] = date('d/m/Y', $result->created_at->timestamp); 
                array_push($results, $result);
            }
            if (empty($detail)) {
                $detail = $result;
            }
        }

        $data['charts'] = $results;
        $data['detail'] = $detail;

        $this->response['success'] = true;
        $this->response['msg'] = "Lấy dữ liệu thành công";
        $this->response['data'] = $data;

        return response()->json($this->response);
    }
}
