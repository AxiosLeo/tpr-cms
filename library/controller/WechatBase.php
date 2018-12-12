<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/12/25 15:54
 */

namespace library\controller;

use EasyWeChat\Factory;
use think\Controller;
use think\facade\Session;

class WechatBase extends Controller
{
    protected $config;

    protected $wechatInfo;

    protected $user;

    protected $wechat = '';

    protected $app;

    public function __construct()
    {
        parent::__construct();

        // wechat 环境变量，可用于公众号切换
        $this->wechat = env('app.wechat', 'default');

        $wechat_config = c('wechat.' . $this->wechat, []);
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