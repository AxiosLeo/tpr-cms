<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:01
 */
namespace library\extend\workman\lib;

use think\exception\HttpResponseException;
use Workerman\Connection\TcpConnection;
use library\extend\workman\Workman;
use think\Loader;
use think\Route;
use think\App;

class Request
{
    /**
     * @param TcpConnection $connection
     * @param array $data
     */
    public static function run($connection,$data){
        \think\Request::clear();
        $connection->lastMessageTime = time();
        $data = self::getResponse($data,$connection);
        if(!empty($data)){
            $connection->send($data);
        }
    }

    private static function getResponse($data,$connection){
        $data = json_decode($data ,true);
        if(empty($data)){
            return Response::wrong(500, 'data format wrong');
        }

        $url      = data($data , 's','index/index/index');
        $params   = data($data , 'params',[]);
        $params   = array_merge($params,['connection_id'=>$connection->connection_id]);
        $dispatch = Route::parseUrl($url);
        $request  = \think\Request::instance();
        $request->setParam($params);

        try{
            $data = App::module($dispatch['module'], Workman::$config , $convert = null , $request);
        }catch (HttpResponseException $exception) {
            $response = $exception->getResponse();
            $data = $response->getContent();
        }catch (\Exception $e){
            return Response::error($e);
        }

        // 清空类的实例化
        Loader::clearInstance();

        return $data;
    }
}