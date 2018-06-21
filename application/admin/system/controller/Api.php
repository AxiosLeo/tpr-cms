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
use tpr\framework\Tool;
use tpr\framework\Doc;

class Api extends AdminLogin
{
    /**
     * 接口管理
     * @return mixed
     * @throws \tpr\framework\Exception
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $domain = env('api.host', '');

            $load_path = [
                ROOT_PATH . 'library',
                ROOT_PATH . 'application/api/'
            ];

            $config = [
                'doc_path' => Doc::getClassPathList(),
                'load_path' => $load_path,
                'app_namespace' => 'tpr\api',
            ];

            $doc = Doc::set($config)->doc();
            $list = [];

            foreach ($doc as $c) {
                $class_name = data($c, 'name');
                if (!empty($c['methods'])) {
                    foreach ($c['methods'] as $m) {
                        $api_name = data($m['comment'], 'title');
                        $api_desc = data($m['comment'], 'desc');
                        $host     = $domain . data($m, 'path');
                        $method   = strtoupper(data($m['comment'], 'method'));
                        $list[]   = [
                            'api_name'   => $api_name,
                            'api_desc'   => $api_desc,
                            'class_name' => $class_name,
                            'host'       => $host,
                            'method'     => $method
                        ];
                    }
                }
            }

            if (isset($this->param['sort'])) {
                $sort  = explode(',', $this->param['sort']);
                $order = explode(',', $this->param['order']);
                $rule  = [];

                foreach ($sort as $k => $v) {
                    $rule[$v] = $order[$k];
                }

                $list = Tool::arraySort($list, $rule);
            }

            $this->result($list);
        }
        return $this->fetch('index');
    }

}