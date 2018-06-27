<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:22
 */

namespace tpr\admin\common\controller;

use tpr\framework\Controller;
use tpr\framework\Request;
use tpr\framework\Session;

class AdminBase extends Controller
{
    protected $config;

    protected $menu;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

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
        // TODO: Implement __destruct() method.
        Session::set('last_url', $this->request->url());
    }
}