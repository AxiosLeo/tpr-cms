<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/25 下午1:09
 */
namespace think;

use think\exception\HttpResponseException;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class Server {

    public static $worker;

    /**
     * @var TcpConnection
     */
    public static $connector ;

    protected $return_type;

    protected static $config;

    public static function run($server = "websocket://0.0.0.0:2346")
    {
        self::$config = App::initCommon();
        self::$worker = new Worker($server);

        self::$worker->count = 4;

        self::$worker->onConnect = function ($connection) {
            Server::connect($connection);
        };

        self::$worker->onMessage = function($connection, $data)
        {
            Server::receive($connection , $data);

        };

        self::$worker->onClose = function($connection)
        {
            Server::close($connection);
        };

        Worker::runAll();

    }

    /**
     * @param $connection
     * @param $data
     * @return bool|null
     */
    public static function receive($connection , $data){
        Request::clear();
        self::$connector = $connection;
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

        return self::result($data);
    }

    /**
     * @param TcpConnection $connection
     */
    public static function connect($connection){
        self::$connector = $connection;

        self::response('connect success');
    }

    /**
     * @param TcpConnection $connection
     */
    public static function close($connection){
        self::$connector = $connection;
        self::response('success close');
    }

    public static function error(\Exception $e){
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

    protected static function result($result = [], array $header = [])
    {
        $result = Tool::checkData2String($result);
        if(isset($result['time'])){
            $result['time'] = time();
        }
        $type = c('default_ajax_return', 'json');
        $data = Response::create($result, $type)->header($header)->getContent();
        return self::$connector->send($data);
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