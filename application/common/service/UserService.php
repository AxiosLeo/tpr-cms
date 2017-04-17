<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/17 14:55
 */
namespace app\common\service;

use think\Config;

class UserService {

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

    public static function logVerifyCode($mobile,$time=60){
        $code = mt_rand(100000,999999);
        RedisService::redis()->switchDB(2)->setex($mobile,$time,$code);
        return $code;
    }

    public static function checkVerifyCode($mobile,$code){
        $log_code = RedisService::redis()->switchDB(2)->get($mobile);
        if(empty($log_code)){
            return 404200;
        }
        if($log_code!=$code){
            $count = RedisService::redis()->switchDB(3)->countNumber('verify_code_counter_'.$mobile);
            if(!$count){
                $count = RedisService::redis()->switchDB(3)->counter('verify_code_counter_'.$mobile,1,60000);
            }
            if($count==5){
                RedisService::redis()->switchDB(2)->delete($mobile);
                return 404200;
            }
            return 400200;
        }

        return 0;
    }

}