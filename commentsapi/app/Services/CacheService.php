<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    const DEFAULT_CACHE_TIME_IN_MINUTES = 300;
    
    public function invalid(){
        return Cache::flush();
    }

    public function add($key, $object, $minutes){
        $expireTimeCache = empty($minutes) ? CacheService::DEFAULT_CACHE_TIME_IN_MINUTES : $minutes;
        return Cache::add($key, json_encode($object), $expireTimeCache);
    }

    public function get($key){
        return json_decode(Cache::get($key));
    }

    public function hasKey($key){
        return Cache::has($key);
    }

}