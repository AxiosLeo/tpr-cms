<?php
/**
 * Created by PhpStorm.
 * User: a3690
 * Date: 2017/4/2
 * Time: 14:16
 */
namespace app\common\service;

use think\Env;
use think\Log;

class SignService {
    public function checkSign($post_timestamp,$post_sign){
        $api_key = Env::get('auth.api_key');
        if(empty($api_key)){
            return 500;
        }
        $sign = $this->makeSign($post_timestamp,$api_key);
        $result = $post_sign!=$sign?false:true;
        if(!$result){
            Log::info($sign);
        }
        return $result;
    }

    private function makeSign($timestamp,$api_key){
        return md5($timestamp.$api_key);
    }
}