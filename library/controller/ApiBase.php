<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/26 12:48
 */
namespace library\controller;

use think\Controller;
use think\Crypt;
use think\Log;
use think\Request;

class ApiBase extends Controller{
    protected $get = [];

    protected $post = [];

    protected $header = [];

    protected static $rsa = PROJECT_NAME;

    protected static $debug = true;

    protected $app_version = "";

    protected $company = "yongdong";

    protected $app_key ;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        $this->get = $this->request->get();

        $this->post = $this->request->post();

        $this->header = $this->request->header();

        if($this->request->header('X-debug') == 'hailunclass'){
            self::$debug = true;
        }

        if(!empty($this->request->header('X-Company'))){
            $company = ['hailun'];
            $tmp = $this->request->header('X-Company');
            $this->company = in_array($tmp , $company) ? $tmp :$this->company ;
        }

//        $this->checkSign();
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
        if (!isset($this->param['timestamp']) || !isset($this->param['sign']) || !isset($this->param['from'])) {
            $this->wrong(406, 'sign error');
        }

        if (empty($this->param['timestamp']) || empty($this->param['sign']) || empty($this->param['from'])) {
            $this->wrong(406, 'sign error');
        }

        if (time() - $this->param['timestamp'] > 10) {
            $this->wrong(406, 'sign timeout');
        }

        $sign = $this->param['sign'];
        $sign_auth = $this->makeSign($this->param['timestamp']);
        if ($sign != $sign_auth) {
            Log::record(['t' => $this->param['timestamp'], 's' => $this->param['sign'], 'right' => $sign_auth], 'debug');
            $this->wrong(406, 'wrong error');
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
}