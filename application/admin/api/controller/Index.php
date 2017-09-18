<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/30 下午3:14
 */
namespace tpr\admin\api\controller;

use library\logic\DocLogic;
use tpr\admin\common\controller\AdminLogin;

class Index extends AdminLogin{
    /**
     * 接口调试
     * @return mixed
     */
    public function index(){

        if($this->request->isPost()){
            $app_path = $this->request->param('app_path',null);
            if(empty($app_path)){
                $app_path = ROOT_PATH . 'application/api';
            }

            $module_namespace = $this->request->param('module_namespace');
            $class_name = $this->request->param('class_name',null);

            $api_list = DocLogic::apiList($class_name , $module_namespace , $app_path);

            $total = count($api_list);
            $this->tableData($api_list,$total);
        }

        $exception = ['admin'];

        $app_list = DocLogic::appList(ROOT_PATH . 'application/' , $exception);
        $this->assign('app_list' , $app_list);

        $app_path = ROOT_PATH . 'application/api';
        $this->assign('app_path',$app_path);

        return $this->fetch();
    }

    public function modules(){
        if($this->request->isPost()){
            $app_path = $this->request->param('app_path');
            $modules = DocLogic::moduleList($app_path);
            $this->tableData($modules);
        }
    }

    public function classes(){
        if($this->request->isPost()){
            $app_path = $this->request->param('app_path');
            $module_namespace = $this->request->param('module_namespace');
            $class_list = DocLogic::classList($module_namespace, $app_path);
            $this->tableData($class_list);
        }
    }

    public function api(){
        if($this->request->isPost()){
            $class_name = $this->request->param('class_name');
            $api_list = DocLogic::apiList($class_name);
            $this->tableData($api_list);
        }
    }
}