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
use App\Services\CrawlSiteService;
use App\Services\ConfigService;
use App\Services\TelegramService;
use App\Services\PostService;
use App\Services\LogService;
use App\Services\ApiService;
use Carbon\Carbon;

class SyncContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $url;
    private $crawlSiteService;
    const LIMIT = 20;

    /*
     * Execute the job.
     *
     * @return void
     */
    public function handle(CrawlSiteService $crawlSiteService, ConfigService $configService, TelegramService $telegramService, LogService $logService, PostService $postService, ApiService $apiService)
    {
        $config = $configService->firstRunConfig();
        if (!$config) return;
        $contents = $postService->getByCondition(['site_id' => $config->crawl_site_id, 'is_remove' => null], ['post_date', 'ASC'])->take(self::LIMIT);

        $maxTimeContent = $config->log->lasted_post_time->toDateTime();
        $authenticateBase64 = $config->syncSite->base64_authenticate;
        $countErr = $countSuccess = 0;
        try {
            foreach ($contents as $content) {
                $params = json_encode([
                    'title'    => $content->post_title ?? "",
                    'content'  => $content->post_content,
                    'status'   => 'publish',
                    'categories' => $content->categories
                ]);

                $postDateCarbon = Carbon::parse($content->post_date);
                $maxTimeContent = $postDateCarbon > $maxTimeContent ? $postDateCarbon : $maxTimeContent;

                $push = $apiService->syncContent($config->syncSite->domain, $params, $authenticateBase64);
                
                if ($push) {
                    $countSuccess += 1;
                } else {
                    $countErr += 1;
                }
            }

            try {
                $ids = array_keys($contents->keyBy("_id")->toArray());
                $postService->updateByArrayId($ids, [
                    'is_remove' => 1
                ]);
            } catch (\Throwable $th) {
                TelegramService::sendMessage("Có lỗi trong quá trình gắn cờ xóa dữ liệu, post_ids: " . $ids);
            }
            
        } catch (\Throwable $th) {
            TelegramService::sendMessage("Có lỗi trong quá trình sync dữ liệu, config_id: " . $config->_id);
        }

        $configService->update($config, [
            'run_last_time' => Carbon::now(),
            'run_next_time' => Carbon::now()->addMinute($config->time_step),
        ]);
        $logService->updateById($config->log->_id, [
            'lasted_post_time' => $maxTimeContent,
            'count_post_sync_success' => $config->log->count_post_sync_success + ($countSuccess),
            'count_post_sync_error' => $config->log->count_post_sync_error + $countErr,
        ]);

        if ($countErr > 0) {
            TelegramService::sendMessage("Có " . $countErr . " bị lỗi trong quá trình sync dữ liệu, config_id: " . $config->_id);
        }
        return true;
    }

    private function isExistPost($contents)
    {
        return count($contents) > 0 ? true : false;
    }

    private function createDataInsert($site, $content)
    {
        $data["post_content"] = $content->content->rendered;
        $data["post_date"] = $content->date;
        $data["post_link"] = $content->link;
        $data["post_modified"] = $content->modified;
        $data["site_id"] = $site->_id;
        return $data;
    }

    private function getData($client, $url)
    {
        try {
            return $client->get($url)->getBody()->getContents();
        } catch (GuzzleException $th) {
            throw $th;
        }
    }

    private function newClient()
    {
        $client = new Client([
            'timeout' => 5,
            'cookies' => true,
            'http_errors' => false,
            'verify' => false
        ]);

        return $client;
    }
}
