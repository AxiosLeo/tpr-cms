<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/1 下午4:23
 */
namespace library\exception;

use Exception;
use think\exception\Handle;
use think\Response;
use traits\controller\Jump;

class HttpException extends Handle {
    use Jump;

    public function render(Exception $e)
    {
        if(c('app_debug',true)){
            return parent::render($e);
        }else{
            $data = [
                'code'=>$e->getCode(),
                'file'=>$e->getFile(),
                'line'=>$e->getLine(),
                'msg'=>$e->getMessage()
            ];
            $req = [
                'code'=>"500",
                'msg'=>"server error",
                'data'=>$data,
                'time'=>$_SERVER['REQUEST_TIME']
            ];

            $return_type = c('default_ajax_return','json');
            if(empty($return_type)){
                $return_type = "json";
            }
            Response::create($req,$return_type,"500")->send();
            die();
        }
    }
}