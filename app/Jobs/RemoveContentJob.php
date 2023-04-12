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
use App\Services\PostService;
use Carbon\Carbon;

class RemoveContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $url;
    public $timeout = 3600;   
    /*
     * Execute the job.
     *
     * @return void
     */
    public function handle(PostService $postService)
    {
        try {
            $postService->removeByCondition(['is_remove' => 1]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
