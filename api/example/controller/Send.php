<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:13
 */
namespace api\example\controller;

use axios\tpr\core\Api;
use api\example\service\UserService;

/**
 * Class Send
 * @package app\example\controller
 */
class Send extends Api {
    /**
     * 发送短信验证码接口
     * @parameter string mobile 手机号
     * @method POST
     */
    public function send(){
        $mobile = $this->param['mobile'];
        $result = $this->sendVerify($mobile);
        if($result->statusCode!="000000"){
            $this->wrong($result->statusMsg);
        }
        $this->response();
    }

    private function sendVerify($to,$time = 60){
        $code = mt_rand(100000,999999);
        $code = UserService::logVerifyCode($to,$code,$time); // 记录验证码，需要redis数据库


//        return $this->sendMessage($to,$data,$temp_id);
    }

    private function sendMessage($to,$send=[],$tempId)
    {
        // TODO: Send Message
    }
}