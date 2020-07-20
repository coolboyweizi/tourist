<?php
/**
 * 图片处理
 */
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImageHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
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
        if (array_get($this->data,'status', 0) == 1) {
            $rst = app('talentList.abstract')->findAll([
                ['talent_id', $this->data['app_id']]
            ],10);
            $logo = [];
            array_walk($rst['data'],function ($item) use(&$logo){
                $priceInfo = app($item['app'].'Price.abstract')->findById($item['price_id']);
                array_push($logo, $priceInfo['appLogo']);
            });

            $tmpPic = app(\App\Contracts\ImageHandleService::class)->init(array_unique($logo))->line()->pixed()->make();
            $upload = app(\App\Contracts\StorageService::class)->upload('xinyishidai-staging','storage/'.$tmpPic);
            \Illuminate\Support\Facades\Storage::delete($tmpPic);
            app('talent.abstract')->update([$this->data['app_id']],[
                'logo'=>$upload['oss-request-url']
            ]);

            // 更新图册
            $thumbs = [];
            for ($i=0; $i<3; $i++){
                $thumbs[$i] = array_get($logo,$i,'https://static.scxysd.com/rtimg2.png');
            }
            \App\Models\TalentModel::find($this->data['app_id'])->update([
                'thumbs' => \GuzzleHttp\json_encode($thumbs)
            ]);

        }
    }
}
