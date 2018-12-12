<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:56
 */

namespace tpr\admin\common\controller;

use library\controller\BaseController;
use think\facade\Session;

class AdminBase extends BaseController
{
    protected $config;

    protected $menu;

    public function __construct()
    {
        parent::__construct();

        $this->assign('module', $this->request->module());

        $this->assign('current_url', $this->request->path());
    }

    protected function tableData($data, $count = 0){
        $this->setResult('count',$count);
        $this->response($data,0);
    }

    public function _empty()
    {
        echo __FUNCTION__;
        return "the function not exits";
    }

    public function __destruct()
    {
        Session::set('last_url', $this->request->url());
    }
}