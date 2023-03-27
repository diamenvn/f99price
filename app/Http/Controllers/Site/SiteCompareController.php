<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteCompareController extends Controller
{
    public function __construct(BrandService $brandService, ProductService $productService)
    {
        $this->brandService = $brandService;
        $this->productService = $productService;
    }

    public function index()
    {
        $data['title'] = "Bảng so sánh giá cả";
        $data['brands'] = $this->brandService->getByCondition(['status' => 1], ['created_at' => 'DESC'])->load('items');
        $data['products'] = $this->productService->getByCondition(['status' => 1]);
        $data['apiRequest'] = route('api.compare.get');
        $data['create'] = route('compare.create');
        $data['sidebarRight'] = "d-none";

        return view('site.compare.index', $data);
    }

    public function create()
    {
        $data['products'] = $this->productService->getByCondition(['status' => 1]);
        $data['action'] = route('compare.store');
        $data['method'] = 'POST';

        return view('site.compare.form', $data);
    }

    public function store(Request $request)
    {
        $request = $request->only(['product']);
        
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            $this->productService->removeByCondition(['status' => 1]);
            foreach ($request['product'] as $key => $value) {
                $insert['ordering'] = $key;
                $insert['product_name'] = $value;
                $insert['status'] = 1;
                $this->productService->create($insert);
            }
            $session->commitTransaction();
            return redirect()->route('compare.index')->with('success', 'Cập nhật danh sách sản phẩm thành công');
        } catch (\Throwable $th) {
            $session->abortTransaction();
            return redirect()->route('compare.index')->with('error', 'Cập nhật thất bại, lỗi ' . $th->getMessage());
        }
    }
}
