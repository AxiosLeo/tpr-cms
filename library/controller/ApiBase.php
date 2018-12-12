<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/26 12:48
 */
namespace library\controller;

use library\logic\Crypt;
use library\connector\Mysql;
use think\Container;
use think\Controller;
use think\exception\HttpResponseException;
use think\facade\Config;
use think\facade\Log;
use think\facade\Response;

class ApiBase extends Controller {

    protected static $rsa = PROJECT_NAME;

    protected static $debug;

    protected static $app_key , $timestamp , $sign , $app_status , $app_secret;

    /**
     * ApiBase constructor.
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function __construct()
    {
        parent::__construct();

        self::$debug = Config::get('app_debug');

        self::$timestamp = $this->request->header('x-timestamp' , 0);

        self::$sign = $this->request->header('x-sign','');

        self::$app_key = $this->request->header('x-app-key','');

        $this->checkSign();

        $this->checkAppKey();
    }

    /**
     * 检验app_key的有效性
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    protected function checkAppKey(){
        $app_version = Mysql::name('app_version')->where('app_key', self::$app_key)->find();
        if(empty($app_version)){
            $this->wrong(400 , 'app_key not exist');
        }

        self::$app_status = data($app_version,'app_status',0);

        $app = Mysql::name('app')->where('app_id', $app_version['app_id'])->field('app_id, app_secret')->find();
        if(empty($app)){
            $this->wrong(400,'app not exist');
        }

        self::$app_secret = $app['app_secret'];
    }

    /**
     * 加密
     * @param $data
     * @param string $type 默认pri
     * @return null|string
     */
    protected function encrypt($data, $type = 'pri')
    {
        $save = $data;
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $data = Crypt::rsa(self::$rsa)->encrypt($data, $type);
        return self::$debug ? $save : $data;
    }

    /**
     * 解密
     * @param $data
     * @param string $type
     * @return mixed|string
     */
    protected function decrypt($data, $type = 'pri')
    {
        $save = $data;
        $data = Crypt::rsa(self::$rsa)->decrypt($data, $type);
        $tmp  = json_decode($data, true);
        if (!empty($tmp)) {
            $data = $tmp;
        }
        return self::$debug ? $save : $data;
    }

    /**
     * 验证数字签名
     * @return bool
     */
    public function checkSign()
    {
        if (self::$debug) {
            return false;
        }

        if (empty($this->timestamp) || empty($this->sign)) {
            $this->wrong(406, 'sign error');
        }

        if (time() - $this->timestamp > 30) {
            $this->wrong(406, 'sign timeout');
        }


        $sign_auth = $this->makeSign(self::$timestamp);

        if (self::$sign != $sign_auth) {
            Log::record(['t' => self::$timestamp, 's' => self::$sign, 'right' => $sign_auth], 'debug');
            $this->wrong(406, 'wrong sign');
        }
        return false;
    }

    /**
     * 生成数字签名
     * @param $timestamp
     * @return string
     */
    private function makeSign($timestamp)
    {
        return md5($timestamp);
    }

    protected $headers = [];

    protected $type = '';

    protected function setResponseType($type)
    {
        $this->type = $type;
    }

    protected function setHeader($header_name, $content = '')
    {
        if (is_array($header_name)) {
            $this->headers = array_merge($this->headers, $header_name);
        } else {
            $this->headers[$header_name] = $content;
        }
    }

    protected function wrong($code = 500, $msg = '')
    {
        $this->response([], $code, $msg);
    }

    protected function response($data, $code = 200, $msg = '')
    {
        $result   = [
            'code' => $code,
            'msg'  => $this->msg($msg),
            'time' => $_SERVER['REQUEST_TIME'],
            'data' => $data
        ];
        $config   = Container::get('config');
        $type     = empty($type) ? $config->get('default_ajax_return') : $type;
        $response = Response::create($result, $type)->header($this->headers);
        throw new HttpResponseException($response);
    }

    protected function output($output = null, $header = [])
    {
        $this->setHeader($header);

        $response = Response::create($output, 'text')->header($this->headers);

        throw new HttpResponseException($response);
    }

    private function msg($message = '')
    {
        if (empty($message)) {
            $tmp = Config::get('code.' . strval($message));
            if (!empty($tmp)) {
                $message = $tmp;
            }
        }
        return $message;
    }
}