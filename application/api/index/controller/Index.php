<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */

namespace tpr\api\index\controller;

use library\controller\BaseController;
use library\logic\Doc;
use library\logic\DocLogic;

/**
 * Class Index
 * @package api\index\controller
 */
class Index extends BaseController
{
    /**
     * hello world
     * @desc example
     * @method get
     */
    public function index()
    {
//        $this->response(["hello world!"]);
        $app_path = ROOT_PATH . 'application/api';
        $module_namespace = $this->request->param('module_namespace');
        $class_name       = $this->request->param('class_name', null);

        $api_list = DocLogic::apiList($class_name, $module_namespace, $app_path);

        halt($api_list);
    }

    /**
     * send $name
     * @desc      example
     *
     * @parameter string name 名称
     * @method post|get
     */
    public function needName()
    {
        $this->response(["name" => $this->param['name']]);
    }

    /**
     * example for cache
     * @desc example
     * @method get
     */
    public function cache()
    {
        sleep(3);
        $this->response(['hello' => "world", "timestamp" => time()]);
    }

    /**
     * get doc
     * @desc example
     * @method get
     */
    public function apiDoc()
    {
        $config = [
            'doc_path'      => Doc::getClassPathList(),
            'load_path'     => [ROOT_PATH . 'library', APP_PATH],
            'app_namespace' => 'tpr\api'
        ];
        $this->response(Doc::set($config)->doc());
    }

    public function name()
    {
        $name = $this->request->param('name', 'name is empty');

        $this->response(['name' => $name]);
    }

}