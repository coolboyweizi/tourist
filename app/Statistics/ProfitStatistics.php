<?php
/**
 * User: Master King
 * Date: 2019/3/1
 */

namespace App\Statistics;


use App\Tools\StatisticsDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProfitStatistics
{

    /**
     * 时间对象
     * @var StatisticsDate|null
     */
    private $date = null;

    /**
     * 数据集合
     * @var Collection
     */
    private $collections = null;

    /**
     *
     * ProfitStatistics constructor.
     * @param StatisticsDate $date
     */
    public function __construct(StatisticsDate $date)
    {
        $this->date = $date;
        $this->collections = DB::table('profit')
            ->where('created','>=', $this->date->getStartDate()->timestamp)
            ->where('updated','<=', $this->date->getEndDate()->timestamp)
            ->get();
    }

    /**
     * 达人收益
     * @param bool $latest 获取最新
     * @return Collection
     */
    public function talent($latest=true)
    {
        return $this->collections->filter(function ($collection) use($latest) {
            return $collection->shared_uid > 0 && ($latest ? $collection->created > $this->date->getEndDate()->timestamp:true);
        })->map(function ($item){
            return array_merge(
                ['name'=>app('user.abstract')->findById($item->talent_uid)['nickname']],
                (array)$item
            );
        })->groupBy('talent_uid')->sortByDesc(function ($item,$key){
            return $item->sum('talent');
        });;
    }

    /**
     * 分享者收益.
     * @param  bool $latest 获取最新
     * @return Collection
     */
    public function shared($latest=true)
    {
        return $this->collections->filter(function ($collection) use($latest) {
            return $collection->shared_uid > 0 && ($latest ? $collection->created > $this->date->getEndDate()->timestamp:true);
        })->groupBy('shared_uid')->sortBy(function ($item){
            return $item->sum('shared');
        })->map(function ($item, $key){
            return collect(array_merge(
                ['name'   => app('user.abstract')->findById($key)['nickname']],
                ['amount' => app('user.abstract')->findById($key)['amount']],
                ['profit' => $item->sum('shared')],
                ['updated'=> app('user.abstract')->findById($key)['updated']]
            ));
        });
    }

    /**
     * 商家收益
     * @param bool $latest
     * @return Collection
     */
    public function merchant($latest = true)
    {
        return $this->collections->filter(function ($collection) use($latest) {
            return $collection->merchant_id > 0 && ($latest ? $collection->created > $this->date->getEndDate()->timestamp:true) ;
        })->groupBy('merchant_id')->sortByDesc(function ($item) {
            return $item->sum('merchant');
        })->map(function ($item, $key){
            return collect(array_merge(
                ['name'=>app('admin.abstract')->findById($key)['name']],
                ['amount'=>app('user.abstract')->findById($key)['amount']],
                ['profit' => $item->sum('merchant')],
                ['updated' => app('user.abstract')->findById($key)['updated']]
            ));
        });
    }

    /**
     * 该段时间内的系统收益列表
     * @return Collection
     */
    public function system(){
       return $this->collections->groupBy(function ($collection, $key){
           return Carbon::createFromTimestamp($collection->created)->format('y-m-d');
       })->map(function ($collect, $key){
           return collect(['money'=>$collect->sum('system')]);
       });
    }

}