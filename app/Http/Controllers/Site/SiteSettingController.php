<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BrandItemService;
use App\Services\BrandService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function __construct(BrandService $brandService, BrandItemService $brandItemService, SettingService $settingService)
    {
        $this->brandService = $brandService;
        $this->brandItemService = $brandItemService;
        $this->settingService = $settingService;
    }

    public function index(Request $request)
    {
        $brandId = $request->input('brand_id', $this->brandService->getByCondition(['status' => 1], ['created_at' => 'DESC'])[0]->_id);

        if ($brandId) {
            $data['brand'] = $this->brandService->firstById($brandId);
        }

        if ($data['brand']) {
            $data['brand'] = $data['brand']->load('items.setting');
        } else {
            return redirect()->route('setting.index');
        }

        $data['title'] = "Trang chủ";
        $data['brands'] = $this->brandService->getByCondition(['status' => 1], ['created_at' => 'DESC'])->load('items');
        $data['sidebarRightUrl'] = 'setting.index';
        $data['action'] = route("setting.update", $brandId);
        $data['method'] = "PUT";

        return view('site.setting.index', $data);
    }

    public function update($id, Request $request)
    {
        $request = $request->only(['link', 'element_lists', 'element_name', 'element_thumbnail', 'element_price', 'element_unit', 'element_url', 'end_pagination', 'element_pagination', 'format_price']);
        
        try {
            $listsBrandItem = $this->brandItemService->getByCondition(['brand_id' => $id])->pluck("_id")->toArray();
            $remove = $this->settingService->removeByCondition(['brand_item_id' => $listsBrandItem]);
            $this->brandItemService->removeByCondition(['brand_id' => $id]);
        } catch (\Throwable $th) {
            $this->response['msg'] = $th->getMessage();
            return response()->json($this->response);
        }


        foreach ($request['link'] as $key => $value) {
            
            //remove 
            $brandItem['brand_id'] = $id;
            $brandItem['url'] = $request['link'][$key];
            $brandItem['status'] = 1;
            $brandItem['schedule_at'] = '12:00';
            $brandItem['schedule_type'] = 'daily';
            $firstBrandItem = $this->brandItemService->create($brandItem);

            if ($firstBrandItem) {
                $update['element_lists'] = $request['element_lists'][$key];
                $update['element_name'] = $request['element_name'][$key];
                $update['element_thumbnail'] = $request['element_thumbnail'][$key];
                $update['element_price'] = $request['element_price'][$key];
                $update['element_unit'] = $request['element_unit'][$key];
                $update['element_url'] = $request['element_url'][$key];
                $update['element_pagination'] = $request['element_pagination'][$key];
                $update['format_price'] = $request['format_price'][$key];
                $update['end_pagination'] = $request['end_pagination'][$key];
                $update['brand_item_id'] = $firstBrandItem->_id;
                $this->settingService->create($update);
            }
        }

        $this->response['msg'] = "Thành công";
        $this->response['success'] = true;

        return response()->json($this->response);
    }

    public function destroy($id)
    {
        $first = $this->brandService->firstById($id);
        if ($first) {
            $remove = $this->brandService->remove($first);
            if ($remove) {
                $this->response['msg'] = "Xoá thành công";
                $this->response['success'] = true;
            }
        }

        return response()->json($this->response);
    }
}
