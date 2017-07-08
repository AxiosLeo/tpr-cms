<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/4 16:58
 */
namespace api\common\service;

use think\Response;
use traits\controller\Jump;
use think\exception\Handle;
use think\Config;
use Exception;


class Http extends Handle{
    use Jump;
    public function render(Exception $e)
    {
        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        if(Config::get('app_debug')){
            return parent::render($e);
        }else{
            $req['code']= "500";
            $req['message'] = "something error";
            $req['data'] = [];
            $return_type = c('default_ajax_return','json');
            if(empty($return_type)){
                $return_type = "json";
            }
            Response::create($req,$return_type,"500")->send();
            die();
        }
    }
}