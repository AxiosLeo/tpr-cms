<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:01
 */
namespace library\extend\workman\lib;

use library\extend\workman\Workman;
use think\App;
use think\exception\HttpResponseException;
use think\Route;
use Workerman\Connection\TcpConnection;

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
            $data = Response::result($data);
            $connection->send($data);
        }
    }

    private static function getResponse($data,$connection){
        $data = json_decode($data ,true);
        if(empty($data)){
            return Response::wrong(500, 'data format wrong');
        }
        $url = data($data , 's','index/index/index');
        $params = data($data , 'params',[]);
        $params = array_merge($params,['connection_id'=>$connection->connection_id]);
        $dispatch = Route::parseUrl($url);
        $request = \think\Request::instance();
        $request->setParam($params);
        try{
            $data = App::module($dispatch['module'], Workman::$config , $convert = null , $request);
        }catch (HttpResponseException $exception) {
            $data = $exception->getResponse();
        }catch (\Exception $e){
            return Response::error($e);
        }

        if ($data instanceof Response) {
            $data = $data->getData();
        }
        return $data;
    }
}