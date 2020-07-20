<?php
/**
 * User: Master King
 * Date: 2018/12/11
 */


if (! function_exists('smartLog')) {

    function smartLog( $path,  $name, $message)
    {

        Log::useDailyFiles(storage_path("logs/${path}/${name}"));
        Log::info($message);


    }
}

if (! function_exists('cache_instance')) {
    function cache_instance($class,...$args){
        global $instanceArr;

        if (!isset($instanceArr) || !is_array($instanceArr)) {
            $instanceArr = [];
        }
        $key = $class.\GuzzleHttp\json_encode($args);
        if(($instance = array_get($instanceArr,$key, false)) === false) {
            $instance = new $class(...$args);
            $instanceArr = array_merge($instanceArr,[
                $key => $instance
            ]);
        }
        return $instance;
    }
}