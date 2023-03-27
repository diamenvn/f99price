<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Helper;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Spatie\Browsershot\Browsershot;
use App\Services\BrandService;
use App\Services\BrandItemService;
use App\Services\LogService;
use App\Services\ResultService;
use App\Services\SettingService;

class CrawlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $url;
    private $brandService;

    /*
     * Execute the job.
     *
     * @return void
     */
    public function handle(BrandService $brandService, BrandItemService $brandItemService, ResultService $resultService, LogService $logService, SettingService $settingService)
    {
        $this->brandService = $brandService;
        $this->brandItemService = $brandItemService;
        $this->resultService = $resultService;
        $this->logService = $logService;
        $this->settingService = $settingService;

        // $this->resultService->removeByCondition(['unit' => '1kg']);return;
        // Lấy ra danh sách url vào sau đó đưa vào foreach để chạy và lấy dữ liệu
        $brandItems = $this->brandItemService->getByCondition(["status" => 1])->load('brand');
        if ($brandItems) {
            $client = $this->newClient();

            foreach ($brandItems as $item) {
                $setting = $this->settingService->firstByCondition(['brand_item_id' => $item->_id]);

                if (!$setting) continue;
                $page = 1;
                while (true) {
                    $pagination = $setting->element_pagination ?? $item->url;
                    $end = $setting->end_pagination ?? null;

                    $url = str_replace("{page}", $page, $pagination);

                    $fetch = $this->getData($client, $url);                    

                    $html = $fetch->getBody()->getContents();

                    if (strpos($html, "{") && json_decode($html)) {
                        $json = json_decode($html);
                        $arr = $this->processResponseJson($json, $setting);

                        if (empty(Helper::convert($json, $setting->element_lists))) {
                            break;
                        }

                    }else{
                        $arr = $this->processResponseHtml($html, $setting, $item);

                        if (isset($end) && !empty($html) && strpos($html, $end) != false) {
                            break;
                        }
                        
                    }

                    if (isset($arr) && count($arr) > 0) {
                        foreach ($arr as $val) {
                            try {
                                $val['brand_id'] = $item->brand_id;
                                $val['brand_item_id'] = $item->_id;

                                $insert = $this->resultService->create($val);
                                // $this->logService->create($insert);
                            } catch (\Throwable $th) {
                                Helper::PushError($th);
                            }
                        }
                    }else{
                        break;
                    }

                    if (strpos($setting->element_pagination, '{page}') === false) {
                        break;
                    }

                    $page += 1;
                }
            }
        }
    }

    /*
    @params $html 
    @return array
    */
    private function processResponseHtml($res, $setting, $brandItem)
    {
        try {
            $doms = Helper::FindByClass(Helper::Crawl($res), $setting->element_lists);
            $result = $doms->each(function ($node) use ($setting, $brandItem) {
                if (isset($setting->element_name) && Helper::FindByClass($node, $setting->element_name)->count()) {
                    $res['name'] = Helper::FindByClass($node, $setting->element_name)->text();
                }
                if (isset($setting->element_url) && Helper::FindByClass($node, $setting->element_url)->count()) {
                    $res['url'] = Helper::FindByClass($node, $setting->element_url)->attr('href');
                }

                if (isset($setting->element_thumbnail) && Helper::FindByClass($node, str_replace("{host}", "", $setting->element_thumbnail))->count()) {
                    $res['thumbnail_url'] = "";
                    if (strpos($setting->element_thumbnail, "{host}") !== false) {
                        $res['thumbnail_url'] = $brandItem->brand->brand_url;
                    }
                    $res['thumbnail_url'] .= Helper::FindByClass($node, str_replace("{host}", "", $setting->element_thumbnail))->attr('src');
                }
                if (isset($setting->element_price) && Helper::FindByClass($node, $setting->element_price)->count()) {
                    $res['price'] = preg_replace('/\D/', '', html_entity_decode(Helper::FindByClass($node, $setting->element_price)->text()));
                    if (isset($setting->format_price)) {
                        $res['price'] = substr($res['price'], 0, $setting->format_price);
                    }
                    
                }

                if (isset($setting->element_unit) && Helper::FindByClass($node, $setting->element_unit)->count()) {
                    $res['unit'] = Helper::FindByClass($node, $setting->element_unit)->text();
                }
                return $res;
            });
        } catch (\Throwable $th) {
            $result = array();
            Helper::PushError($th);
        }

        return $result;
    }

    private function processResponseJson($json, $setting)
    {
        $res = [];
        try {
            $lists = Helper::convert($json, $setting->element_lists);
            
            if (!empty($lists)) {
                foreach ($lists as $key => $item) {
                    $result = [];
                    if (isset($setting->element_name)) {
                        $result['name'] = Helper::convert($item, $setting->element_name);
                    }
                    if (isset($setting->element_name)) {
                        $result['url'] = Helper::convert($item, $setting->element_url);
                    }
                    if (isset($setting->element_name)) {
                        $result['thumbnail_url'] = Helper::convert($item, $setting->element_thumbnail);
                    }
                    if (isset($setting->element_name)) {
                        $result['price'] = Helper::convert($item, $setting->element_price);
                    }
                    array_push($res, $result);
                }
            }
        } catch (\Throwable $th) {
            $res = array();
            Helper::PushError($th);
        }
        return $res;
    }

    private function getData($client, $url)
    {
        try {
            return $client->get($url);
        } catch (GuzzleException $th) {
            throw $th;
        }
    }

    private function newClient()
    {
        $client = new Client([
            'timeout' => 30,
            'cookies' => true,
            'http_errors' => false
        ]);

        return $client;
    }
}
