<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/31 11:20
 */
namespace app\common\middleware;

use think\Db;
use think\Session;
use think\Cache as ThinkCache;
class Cache {
    public function set($session_id,$req,$expire,$param){

        $cache_md5 = md5(serialize($param));
        Session::set($this->identify."_md5",$cache_md5,$filter['cache']);
        ThinkCache::set(session_id(),$req,$filter['cache']);
    }
}