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
use tpr\framework\Request;

class WechatLogin extends WechatBase
{
    /**
     * WechatLogin constructor.
     * @param Request|null $request
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     * @throws \tpr\framework\Exception
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        if(empty($this->wechatInfo)){
            $this->redirect('index/auth/auth',['redirect'=>base64_encode($this->url)]);
        }

        if(empty($this->user)){
            $this->user = UserLogic::getUserInfoByOpenId($this->wechatInfo['openid'],$this->wechat);
        }
        // 跳转至账号绑定
//        if(empty($this->user)){
//            $this->redirect('user/account/bind',['redirect'=>base64_encode($this->url)]);
//        }
    }
}