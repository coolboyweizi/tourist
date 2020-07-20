<?php
/**
 * User: Master King
 * Date: 2019/1/11
 */

return [
    'alias' => '热门模块',
    'model' =>  \App\Models\HotAppModel::class,
    'closure' => [
       '_after_find_all' => function($pageList) {
           $items = $pageList['data'];
           $appServices = [];
           foreach ($items as $key=>$value){
               $app = $value['app'];
               $app_id = $value['app_id'];

               if ( ($appInstance = array_get($appServices,$app,false)) == false ){
                    $appInstance = app($app.'.abstract');
                    $appServices[$app] = $appInstance;
               }
               try {
                   $data = $appInstance->findById($app_id);
               }catch (Exception $exception){
                   $data = \Illuminate\Support\Facades\DB::table($app)->where('id',$app_id)->first();
                   if (($merchantId = array_get($data,'merchant_id',0)) > 0){
                       $merchant = app('admin.abstract')->findById($merchantId)['name'];
                   }else {
                       $merchant = '无';
                   }
                   $data = array_merge(
                       (array)$data,
                        [
                            'merchant' => $merchant ,
                            'appAlias' => config('extension')[$app]['alias'],
                            'title' => "<span style='color: red'>(已删除)</span>".$data->title
                        ]
                   );
               };
               $items[$key] = array_merge(
                   $value,
                    $data
               );
           }
           return [
               'data' => $items
           ];
       }
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::HOT_SERVICE_EXCEPTION
];