<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:08
 */

namespace tpr\admin\system\controller;

use tpr\admin\common\controller\AdminLogin;

class Setting extends AdminLogin
{
    /**
     * 参数设置
     * @return mixed|string
     */
    public function index()
    {
        if (!is_file(ROOT_PATH . '.env')) {
            file_put_contents(ROOT_PATH . '.env',file_get_contents(ROOT_PATH . '.env.example'));
        }
        $env = parse_ini_file(ROOT_PATH . '.env', true);
        $this->assign('env', $env);
        return $this->fetch('index');
    }
}