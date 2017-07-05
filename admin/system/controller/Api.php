<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */
namespace admin\system\controller;

use admin\common\controller\HomeLogin;
use think\Doc;
use think\Response;

class Api extends HomeLogin{
    public function index(){
        if ($this->request->isPost()) {
            $domain = env('api.host', '');
            $api_dir = [
                ROOT_PATH . 'api/index/controller',
            ];
            Doc::config($api_dir, ROOT_PATH . 'api');
            $doc = Doc::doc();
            $list = [];
            foreach ($doc as $c) {
                $class_name = data($c, 'name');
                if (!empty($c['methods'])) {
                    foreach ($c['methods'] as $m) {
                        $api_name = data($m['comment'], 'title');
                        $api_desc = data($m['comment'], 'desc');
                        $host = $domain . data($m, 'path');
                        $method = strtoupper(data($m['comment'], 'method'));
                        $list[] = [
                            'api_name' => $api_name,
                            'api_desc' => $api_desc,
                            'class_name' => $class_name,
                            'host' => $host,
                            'method' => $method
                        ];
                    }
                }
            }
            \think\Log::record($this->param, 'debug');

            Response::create($list, 'json')->header([])->send();
        }
        return $this->fetch('index');
    }

}