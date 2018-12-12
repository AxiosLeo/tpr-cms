<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/12/25 16:02
 */

namespace library\controller;

use library\logic\UserLogic;
use think\facade\Session;

class WechatLogin extends WechatBase
{
    /**
     * WechatLogin constructor.
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function __construct()
    {
        parent::__construct();
        if (empty($this->wechatInfo)) {

            Session::set("user_redirect", base64_encode($this->request->url(true)));
            $this->redirect('index/auth/auth');
        }

        if (empty($this->user)) {
            $this->user = UserLogic::getUserInfoByOpenId($this->wechatInfo['openid'], $this->wechat);
        }
        // 跳转至账号绑定
//        if(empty($this->user)){
//            $this->redirect('user/account/bind',['redirect'=>base64_encode($this->url)]);
//        }
    }
}