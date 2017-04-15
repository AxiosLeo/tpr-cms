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
            Log::record(['post_timestamp'=>$post_timestamp,'need'=>$sign]);
        }
        return $result;
    }

    /**
     * 生成签名示例方法，建议自定义生成规则
     * @param $timestamp
     * @param $api_key
     * @return string
     */
    private function makeSign($timestamp,$api_key){
        return md5($timestamp.$api_key);
    }
}