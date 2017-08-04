<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */

namespace tpr\admin\system\controller;

use tpr\admin\common\controller\AdminLogin;
use think\Tool;
use think\Doc;

class Api extends AdminLogin
{
    public function index()
    {
        if ($this->request->isPost()) {
            $domain = env('api.host', '');
            $api_dir = [
                ROOT_PATH . 'api/index/controller',
            ];
            Doc::config($api_dir, ROOT_PATH . 'api/common');
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

            if (isset($this->param['sort'])) {
                $sort = explode(',', $this->param['sort']);
                $order = explode(',', $this->param['order']);
                $rule = [];

                foreach ($sort as $k => $v) {
                    $rule[$v] = $order[$k];
                }

                $list = Tool::arraySort($list, $rule);
            }

            $this->ajaxReturn($list);
        }
        return $this->fetch('index');
    }

}