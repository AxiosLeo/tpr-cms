<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:10
 */

namespace admin\index\controller;

use admin\common\controller\HomeLogin;

class Index extends HomeLogin
{
    public function index()
    {
        $this->assign('menu', $this->menu());
        return $this->fetch('index');
    }

    public function main()
    {
        return $this->fetch('main');
    }

    public function env()
    {
        $data = [
            'domain' => $this->request->domain(),
            'os' => PHP_OS,
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'server_env' => PHP_VERSION,
            'api_number' => '',
            'upload_limit' => ini_get('upload_max_filesize'),
            'username' => $this->user['username']
        ];
        $this->ajaxReturn($data);
    }
}