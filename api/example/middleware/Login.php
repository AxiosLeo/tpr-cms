<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:15
 */
namespace api\example\middleware;

use axios\tpr\core\Middleware;
use think\Request;

class Login extends Middleware{
    public function before(Request $request){
//        $module     = $request->module();
//        $controller = $request->controller();
//        $action     = $request->controller();
//
//        $param      = $this->param;
    }

    public function after(Request $request,array $response){

    }
}