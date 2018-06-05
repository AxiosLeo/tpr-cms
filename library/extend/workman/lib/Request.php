<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:01
 */
namespace library\extend\workman\lib;

use tpr\framework\exception\HttpResponseException;
use Workerman\Connection\TcpConnection;
use library\extend\workman\Workman;
use tpr\framework\Loader;
use tpr\framework\App;

class Request
{
    /**
     * @param TcpConnection $connection
     * @param array $data
     */
    public static function run($connection,$data){
        \tpr\framework\Request::clear();
        $connection->lastMessageTime = time();
        $data = self::getResponse($data,$connection);
        if(!empty($data)){
            $connection->send($data);
        }
    }

    private static function getResponse($data,$connection){
        $temp = json_decode($data ,true);
        if(empty($temp)){
            return Response::wrong(500, 'data format wrong');
        }else{
            $data = $temp;
        }
        $request = \tpr\framework\Request::instance();
        $config = Workman::$config;
        $params = data($data , 'params',[]);
        if(!is_array($params)){
            $params = [$params];
        }
        if(!is_array($data)){
            $data = [$data];
        }
        $url = data($data , 's' , 'index/index/index');
        $request->setParam($params);

        $params = array_merge($params,['connection_id'=>$connection->connection_id]);

        $request->setParam($params);

        try{
            $dispatch = Run::request($url , $request,$config);
            App::module($dispatch['module'],$config,$convert = null,$request);
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