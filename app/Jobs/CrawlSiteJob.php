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
use App\Services\PostService;
use App\Services\TelegramService;
use Carbon\Carbon;

class CrawlSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $url;
    private $crawlSiteService;

    /*
     * Execute the job.
     *
     * @return void
     */
    public function handle(CrawlSiteService $crawlSiteService, PostService $postService, TelegramService $telegramService)
    {
        $site = $crawlSiteService->firstByCondition(
            ['status' => 1],
            ['crawled_last_time' => 'ASC']
        );

        if (!isset($site)) {
            return;
        }

        if ($site->crawled_last_time->addMinute($site->time_step) > Carbon::now()) { // Chưa đến lúc phải chạy
            return;
        }

        $countSuccess = 0;
        $client = $this->newClient();
        $currentPage = 1;
        $crawledLastTime = $crawledLastTimeNew = ($site->crawled_last_time ?? $site->created_at);
        $isWhileLoop = true;
        
        while ($isWhileLoop) {
            try {
                $url = $site->domain . config("app.endpoint_crawl") . "?page=" . $currentPage;
                $contents = json_decode($this->getData($client, $url));

                if (!$this->isExistPost($contents)) {
                    // hết content, break while
                    $isWhileLoop = false;
                    break;
                }

                foreach ($contents as $content) {
                    $crawledLastTimeNew = $content->date > $crawledLastTimeNew ? $content->date : $crawledLastTimeNew;

                    if ($content->date <= $crawledLastTime) { $isWhileLoop = false; continue; }

                    $data = $this->createDataInsert($site, $content);
                    $create = $postService->create($data);
                    if ($create) {
                        $countSuccess += 1;
                    }
                }
                $currentPage += 1;
            } catch (\Throwable $th) {
                $crawledLastTimeNew = Carbon::now();
                $isWhileLoop = false;
                break;
            }
        }

        $lastTime = is_string($crawledLastTimeNew) ? Carbon::parse($crawledLastTimeNew) : Carbon::parse($crawledLastTimeNew->toDateTime());
        if ($lastTime->addMinute($site->time_step) <= Carbon::now()) {
            $lastTime = Carbon::now();
        }

        $crawlSiteService->update($site, [
            'crawled_last_time' => $lastTime
        ]);
        
        if ($countSuccess) {
            TelegramService::sendMessage("Đã lấy" . $countSuccess . " post từ " . $site->domain ." thành công");
        }
        
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
        $data["post_title"] = $content->title->rendered;
        $data["post_modified"] = $content->modified;
        $data["categories"] = $content->categories;
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
            'http_errors' => false
        ]);

        return $client;
    }
}
