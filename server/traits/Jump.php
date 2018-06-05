<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:29
 */

namespace server\traits;

use tpr\framework\App;
use tpr\framework\exception\HttpResponseException;
use tpr\framework\Request;
use tpr\framework\Response;
use tpr\framework\Route;

/**
 * Trait Jump
 * @package server\traits
 * @method static result($result, $header)
 */
trait Jump
{
    protected static $config;

    protected static $ret = 200;

    protected static $msg = '';

    protected static function init(){
        self::$config = App::initCommon();
    }

    protected static function data($data, $instance = []){
        Request::clear();
        $data = json_decode($data ,true);
        if(empty($data)){
            self::$ret = 500;
            self::$msg = 'data format wrong';
            return false;
        }
        $url = data($data , 's','index/index/index');
        $params = data($data , 'params',[]);
        $dispatch = Route::parseUrl($url);
        try{
            $request = Request::instance();
            $request->setParam($params);
            $request->instance = $instance;
            $data = App::module($dispatch['module'], self::$config , $convert = null , $request);
        }catch (HttpResponseException $exception) {
            $data = $exception->getResponse();
        }catch (\Exception $e){
            return self::error($e);
        }

        if ($data instanceof Response) {
            $data = $data->getData();
        }
        return $data;
    }

    protected static function error(\Exception $e){
        $data = [
            'code'=>$e->getCode(),
            'file'=>$e->getFile(),
            'line'=>$e->getLine(),
            'msg'=>$e->getMessage()
        ];
        return self::response($data, 500 , 'server error');
    }

    protected static function wrong( $code = 500,  $message = '', array $header = []){
        return self::response([], $code, $message, $header);
    }

    public static function response($data = [], $code = 200, $message = 'success', array $header = []){
        if ($code != 200 && empty($message)) {
            $message = c('code.' . strval($code), '');
        }
        $result = [
            'code' => $code,
            'msg'  => self::msg($message),
            'time' => time(),
            'data' => $data,
        ];

        return self::result($result, $header);
    }

    private static function msg($message = '')
    {
        $message = lang($message);
        if (is_array($message)) {
            $message = '';
        }

        return $message;
    }
}