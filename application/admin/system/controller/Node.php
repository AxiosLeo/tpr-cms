<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/29 14:46
 */

namespace tpr\admin\system\controller;

use library\logic\NodeLogic;
use tpr\admin\common\controller\AdminLogin;

/**
 * Class Node
 * @package tpr\admin\system\controller
 */
class Node extends AdminLogin
{
    /**
     * 权限管理
     */
    public function index(){
        if($this->request->isPost()){
            $page = $this->request->param('page',1);
            $limit= $this->request->param('limit',10);
            $class_path = [
                APP_PATH . 'index/controller',
                APP_PATH . 'system/controller',
                APP_PATH . 'user/controller',
            ];
            $result = NodeLogic::adminNode($page , $limit , $class_path);
            $this->tableData($result['list'],$result['count']);
        }

        return $this->fetch();
    }
}