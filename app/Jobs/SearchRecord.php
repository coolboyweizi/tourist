<?php

/**
 * 搜索记录队列处理
 */
namespace App\Jobs;

use App\Models\SearchRecordModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data = [];

    /**
     * Create a new job instance.
     *
     * @param  array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SearchRecordModel::firstOrCreate([
            'app' => $this->data['app'],
            'keywords' => $this->data['keywords'],
            'times' => date('ymd')
        ])->increment('count');
    }
}
