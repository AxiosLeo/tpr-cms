<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 16:06
 */
namespace tpr\wechat\index\controller;

use library\controller\WechatLogin;

class Index extends WechatLogin
{
    public function index(){
        echo 'hello';
    }

    public function api(){
        //1. 将timestamp , nonce , token 按照字典排序
        $timestamp = $this->request->param('timestamp','');
        $nonce = $this->request->param('nonce','');
        $token = "";
        $signature = $this->request->param('signature','');
        $array = array($timestamp,$nonce,$token);
        sort($array);

        //2.将排序后的三个参数拼接后用sha1加密
        $str = implode('',$array);
        $str = sha1($str);

        //3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
        if($str == $signature)
        {
            echo $this->request->param('echostr','echostr');
        }
        die();
    }
}