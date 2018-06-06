<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 15:54
 */

namespace library\controller;

use tpr\framework\Controller;
use tpr\framework\Request;
use tpr\framework\Session;
use Wechat\WechatOauth;

class WechatBase extends Controller
{
    protected $Oauth;

    protected $url;

    protected $param;

    protected $config;

    protected $redirect;

    protected $wechatInfo ;

    protected $user ;

    protected $wechat = '';

    public function __construct(Request $request = null,$wechat_config = 'default')
    {
        parent::__construct($request);

        // 配置环境变量，强制使用某一个微信公众号，比如"微信公众号测试平台"
        $this->wechat = env('app.wechat',$wechat_config);

        $wechat_config = c('wechat.' . $wechat_config ,[]);
        $this->config = [
            'cachepath'      => RUNTIME_PATH . "log_wechat",
            'appid'          => $wechat_config['app_id'],
            'appsecret'      => $wechat_config['app_secret'],
            'encodingaeskey' => $wechat_config['encodingaeskey'],
            'token'          => $wechat_config['token'],
            'state'          => $wechat_config['state'],
            'host'           => $wechat_config['host']
        ];

        $this->Oauth = new WechatOauth($this->config);

        $this->url = $this->request->path();

        $this->redirect = isset($this->param['redirect']) ? base64_decode($this->param['redirect']) : 'index/index/index';

        $this->wechatInfo = Session::get('wechat_info' , PROJECT_NAME);

        $this->user = Session::get('user_info' , PROJECT_NAME);
    }
}