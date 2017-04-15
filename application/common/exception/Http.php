<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 15:41
 */
namespace app\common\exception;

use Exception;
use think\Env;
use think\Exception\Handle;
use think\Response;

class Http extends Handle{
    public function render(Exception $e)
    {
        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        if(Env::get('debug.status')){
            return parent::render($e);
        }else{
            $req['code']= "500";
            $req['message'] = "something error";
            $req['data'] = [];
            Response::create($req,'json',"500")->send();
            die();
        }
    }
}