<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:29
 */

namespace server\traits;

use think\App;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Route;

/**
 * Trait Jump
 * @package server\traits
 * @method static result($result, $header)
 */
trait Jump
{
    protected static $config;

    protected static function init(){
        self::$config = App::initCommon();
    }

    protected static function data($data){
        Request::clear();
        $data = json_decode($data ,true);
        if(empty($data)){
            return self::wrong(500, 'data format wrong');
        }
        $url = data($data , 's','index/index/index');
        $params = data($data , 'params',[]);
        $dispatch = Route::parseUrl($url);
        try{
            $request = Request::instance();
            $request->setParam($params);
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

    protected static function response($data = [], $code = 200, $message = 'success', array $header = []){
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