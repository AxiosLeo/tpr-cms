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
use axios\tpr\service\MongoService;
use think\Env;
use think\Log;
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

    public function log(){
        return $this->fetch('log',['list'=>[]]);
    }

    public function getLogs(){
        $page = isset($this->param['page'])?$this->param['page']:1;
        $logs = MongoService::name('tpr_log')->page($page)->limit(15)->order('datetime')->select();
    }
}