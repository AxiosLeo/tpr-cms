<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-13 09:55
 */

namespace library\exception;

use think\exception\Handle;
use think\facade\Config;
use think\facade\Response;

class HttpRestException extends Handle
{

    public function render(\Exception $e)
    {
        if (Config::get('app_debug')) {
            return parent::render($e);
        } else {
            $data = [
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'msg'  => $e->getMessage()
            ];
            $req  = [
                'code' => "500",
                'msg'  => "server error",
                'data' => $data,
                'time' => $_SERVER['REQUEST_TIME']
            ];

            $return_type = c('default_ajax_return', 'json');
            if (empty($return_type)) {
                $return_type = "json";
            }
            Response::create($req, $return_type, "500")->send();
            die();
        }
    }
}