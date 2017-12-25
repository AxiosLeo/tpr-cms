<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 16:02
 */

namespace library\controller;


use library\logic\UserLogic;
use think\Request;

class WechatLogin extends WechatBase
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        if(empty($this->wechatInfo)){
            $this->redirect('user/auth/auth',['redirect'=>base64_encode($this->url)]);
        }

        if(empty($this->user)){
            $this->user = UserLogic::getUserInfoByOpenId($this->wechatInfo['openid'],$this->wechat);
        }

        if(empty($this->user)){
            $this->redirect('user/account/bind',['redirect'=>base64_encode($this->url)]);
        }
    }
}