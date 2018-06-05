<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:14
 */

namespace library\extend\workman\lib;

use tpr\framework\Tool;

class Response
{
    /**
     * @param Connection $connection
     * @param array|string $data
     */
    public static function send($connection,$data){
        if(is_array($data)){
            $data = json_encode($data);
        }
        $result = $connection->send($data);
        if($result !== true){
            Connect::close($connection);
        }
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

    public static function wrong( $code = 500,  $message = '', array $header = []){
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

    public static function result($result = [], array $header = [])
    {
        $result = Tool::checkData2String($result);
        if(isset($result['time'])){
            $result['time'] = time();
        }
        $type = c('default_ajax_return', 'json');
        $data = \tpr\framework\Response::create($result, $type)->header($header)->getContent();
        return $data;
    }
}