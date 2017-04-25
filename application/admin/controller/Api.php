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
        $domain = Env::get('web.host');
        $last_str = substr($domain,-1);
        if($last_str!= "/"){
            $domain .= "/";
        }
        $this->assign('domain',$domain);
        return $this->fetch('index',['list'=>$api]);
    }
}