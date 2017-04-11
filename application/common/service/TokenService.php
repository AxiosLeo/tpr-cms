<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/11 14:41
 */
namespace app\common\service;

use think\Config;

class TokenService {

    public static function setToken($token,$user,$expire=0){
        $user_id = $user['id'];
        $user = serialize($user);
        if(empty($expire)){
            $expire = Config::get('setting.token.token_expire');
        }
        $expire = empty($expire)?3600:$expire;
        RedisService::redis()->switchDB(1)->hSet("login_token",$user_id,$token);
        return RedisService::redis()->switchDB(1)->set($token,$user,$expire);
    }

    public static function checkToken($token){
        $user = RedisService::redis()->switchDB(1)->get($token);
        if(empty($user)){
            return 403101; // token timeout
        }
        $user = unserialize($user);
        $user_id = $user['id'];

        $hash_token = RedisService::redis()->switchDB(1)->hGet("login_token",$user_id);
        if($hash_token!==$token){
            return 403100; // other login
        }

        return $user; //pass
    }

    public static function updateTokenExpire($token){
        $user = RedisService::redis()->switchDB(1)->get($token);
        if(empty($user)){
            return 2; // token timeout
        }
        $expire = Config::get('setting.token.token_expire');
        $expire = empty($expire)?3600:$expire;

        return RedisService::redis()->switchDB(1)->set($token,$user,$expire);
    }
}