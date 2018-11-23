<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/12/25 15:54
 */

namespace library\controller;

use EasyWeChat\Factory;
use tpr\framework\Controller;
use tpr\framework\Request;
use tpr\framework\Session;

class WechatBase extends Controller
{
    protected $config;

    protected $wechatInfo;

    protected $user;

    protected $wechat = '';

    protected $app;

    public function __construct(Request $request = null, $wechat_config = 'default')
    {
        parent::__construct($request);

        // 配置环境变量，强制使用某一个微信公众号，比如"微信公众号测试平台"
        $this->wechat = env('app.wechat', $wechat_config);

        $wechat_config = c('wechat.' . $wechat_config, []);
        $callback      = "/index/auth/authCallback?redirect=" . Session::get('user_redirect');
        $this->config  = [
            'app_id'        => $wechat_config['app_id'],
            'secret'        => $wechat_config['app_secret'],

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => $callback,
            ],
        ];

        $this->app = Factory::officialAccount($this->config);

        $this->wechatInfo = Session::get('wechat_info', PROJECT_NAME);

        $this->user = Session::get('user_info', PROJECT_NAME);
    }
}