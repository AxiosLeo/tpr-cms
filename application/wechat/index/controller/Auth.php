<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/12/25 16:07
 */

namespace tpr\wechat\index\controller;

use library\connector\Mysql;
use library\controller\WechatBase;
use library\logic\UserLogic;
use tpr\framework\Cache;
use tpr\framework\Request;
use tpr\framework\Session;

class Auth extends WechatBase
{
    /**
     * @var \Overtrue\Socialite\Providers\WeChatProvider
     */
    protected $oauth;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->oauth = $this->app->oauth;
    }

    public function auth()
    {
        $redirect = $this->oauth->scopes(['snsapi_userinfo'])->redirect()->getTargetUrl();
        $this->redirect($redirect);
    }

    public function authCallback()
    {

        $result = $this->oauth->user();
        $result->getAccessToken();
        $token = $result->getAccessToken();
        Cache::set('access_token', $token->getToken(), 7000);
        Cache::set('refresh_token', $token->getAttribute("refresh_token"));
        $user       = $result->getOriginal();
        $wechatInfo = $user;

        if (!empty($wechatInfo)) {
            $insert = [
                'wechat'     => $this->wechat,
                'nickname'   => $wechatInfo['nickname'],
                'sex'        => $wechatInfo['sex'],
                'headimgurl' => $wechatInfo['headimgurl'],
                'unionid'    => isset($wechatInfo['unionid']) ? $wechatInfo['unionid'] : "",
                'openid'     => $wechatInfo['openid']
            ];
            Mysql::name('wx_userinfo')->insert($insert, true);
        }

        Session::set('wechat_info', $wechatInfo, PROJECT_NAME);
        UserLogic::getUserInfoByOpenId($wechatInfo['openid'], $this->wechat);

        $redirect = $this->request->param("redirect", "");
        if (!empty($redirect)) {
            $redirect = base64_decode($redirect);
        } else {
            $redirect = $this->request->host();
        }
        header("location: " . $redirect);
    }

    public function api()
    {
        //1. 将timestamp , nonce , token 按照字典排序
        $timestamp = $this->request->param('timestamp', '');
        $nonce     = $this->request->param('nonce', '');
        $token     = $this->config['token'];
        $signature = $this->request->param('signature', '');
        $array     = array($timestamp, $nonce, $token);
        sort($array);

        //2.将排序后的三个参数拼接后用sha1加密
        $str = implode('', $array);
        $str = sha1($str);

        //3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
        if ($str == $signature) {
            echo $this->request->param('echostr', 'echostr');
        }
        die();
    }
}