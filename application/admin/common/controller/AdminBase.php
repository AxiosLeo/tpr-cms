<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:22
 */

namespace tpr\admin\common\controller;

use library\controller\HomeBase;
use tpr\admin\common\model\Menu;
use think\Request;
use think\Session;

class AdminBase extends HomeBase
{
    protected $config;

    protected $menu;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        $this->assign('module', $this->request->module());

        $this->assign('current_url', $this->request->path());
    }

    public function menu($all = true)
    {
        $parent_menu = Menu::model()->menus(0, $all);
        foreach ($parent_menu as &$m) {
            $m['sub'] = Menu::model()->menus($m['id'], $all);
        }
        return $parent_menu;
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