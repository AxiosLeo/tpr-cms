<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 17:16
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\ApiDocService;
use think\Env;
use think\Request;

class Api extends HomeLogin{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-cogs');
    }

    public function index(){
        $api = ApiDocService::api();
        $this->assign('domain',domain());
        return $this->fetch('index',['list'=>$api]);
    }

    public function detail(){
        $class = $this->param['class'];
        $this->assign('class_name',$class);
        $method = $this->param['method'];
        $result = ApiDocService::makeMethodDoc($class,$method);
        $this->assign('domain',domain());
        return $this->fetch('detail',['data'=>$result]);
    }
}