<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 10:18
 */
namespace app\common\controller;

use app\common\service\LangService;
use think\Cache;
use think\Config;
use think\Controller;
use think\Env;
use think\Request;
use think\Response;

class ApiBase extends Controller{
    /**
     * 当前请求方法：post,get...
     * @var
     */
    protected $method;

    /**
     * 当前请求参数
     * @var mixed
     */
    protected $param;

    /**
     * 接口请求配置
     * @var mixed
     */
    protected $filter;

    /**
     * 当前路由信息
     * @var string
     */
    protected $route;

    /**
     * 当前访问路径
     * @var string
     */
    protected $path;

    /**
     * 当前请求是否缓存
     * @var bool
     */
    protected $cache = false;

    /**
     * 接口配置名称
     * @var
     */
    protected $filter_name;

    /**
     * 当前请求标识
     * @var string
     */
    protected $identify = '';

    /**
     * 调试状态
     * @var bool
     */
    protected $debug = false;

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->method  = $this->request->method();
        $this->param   = $this->request->param();
        $this->route   = $this->request->route();
        $this->filter  = Config::get('filter');
        $route         = $this->request->routeInfo();

        $this->route   = '';
        if(!empty($route['rule'])){
            foreach ($route['rule'] as $key=>$r){
                $this->route = $key==0? $this->route.$r:$this->route."/".$r;
            }
        }

        $this->path    = $this->request->path();
        $this->debug   = Env::get("debug.status");

        $this->filter(); //请求过滤

        $this->middleware('before');  //前置中间件
    }

    /**
     * 请求过滤
     * @return bool|mixed
     */
    protected function filter(){
        $this->sign();
        /*** 获取接口请求配置 ***/
        if(!empty($this->route) && isset($this->filter[$this->route])){
            $this->filter_name = $this->route;
            $filter = $this->filter[$this->filter_name];
        }else if(isset($this->filter[$this->path])){
            $this->filter_name = $this->path;
            $filter = $this->filter[$this->filter_name];
        }else{
            $filter = [];
        }

        if(!empty($filter)){
            /*** 接口缓存 ***/
            if(isset($filter['cache']) && !$this->debug){
                $this->cache = true;
                $param_md5 = md5(serialize($this->param));
                $response_cache = Cache::get($this->filter_name.$param_md5);
                if(!empty($response_cache)){
                    $this->send($response_cache);
                }
            }

            /*** 设备请求过滤 ***/
            if(isset($filter['mobile']) && $filter['mobile']===true){
                if(!$this->request->isMobile()){
                    $this->wrong(406);
                }
            }

            /*** 请求参数过滤 ***/
            $Validate = validate($filter['validate']);
            $check = isset($filter['scene'])?$Validate->scene($filter['scene'])->check($this->param):$Validate->check($this->param);
            if(!$check){
                return $this->wrong(400,$Validate->getError());
            }
        }
        return true;
    }

    /**
     * 中间件
     * @param string $when
     */
    private function middleware($when='before'){
        /*** 获取中间件配置 ***/
        $middleware = Config::get('middleware.'.$when);
        if(!empty($this->route) && isset($middleware[$this->route])){
            $m = $middleware[$this->route];

        }else if(isset($middleware[$this->path])){
            $m = $middleware[$this->path];
        }else{
            $m = [];
        }

        /*** 使用中间件 ***/
        if(!empty($m)){
            $Middleware = middleware($m['middleware']);
            $func = isset($m['func']) && !empty($m['func']) ? $m['func']:"index"; // default to index
            call_user_func([$Middleware,$func]);
        }
    }

    private function sign(){
        $sign_status = Env::get('auth.sign_status');

        if(!empty($sign_status)){
            $setting_sign = Config::get('setting.sign');
            if(empty($setting_sign)){
                $setting_sign = ['timestamp_name'=>'t','sign_name'=>'s','sign_expire'=>10];
            }
            if(!isset($setting_sign['timestamp_name']) || empty($setting_sign['timestamp_name'])){
                $setting_sign['timestamp_name'] = 'timestamp';
            }
            if(!isset($setting_sign['sign_name']) || empty($setting_sign['sign_name'])){
                $setting_sign['sign_name'] = 'sign';
            }
            if(!isset($setting_sign['sign_expire']) || empty($setting_sign['sign_expire'])){
                $setting_sign['sign_expire'] = 10;
            }
            if(!isset($this->param[$setting_sign['timestamp_name']])){
                $this->wrong(401,'sign error');
            }
            $timestamp = $this->param[$setting_sign['timestamp_name']];

            if(!isset($this->param[$setting_sign['sign_name']])){
                $this->wrong(401,'sign error');
            }
            $sign = $this->param[$setting_sign['sign_name']];

            if(time()-intval($timestamp) > intval($setting_sign['sign_expire'])){
                $this->wrong(401,'sign timeout');
            }

            $SignService = middleware("SignService",'service');
            $sign_result = call_user_func_array([$SignService,'checkSign'],[$timestamp,$sign]);

            if($sign_result===500){
                $this->wrong(401,' Env->auth:api_key not exits');
            }
            if(!$sign_result){
                $this->wrong(401,'wrong sign');
            }
        }
    }

    /**
     * 接口缓存
     * @param $req
     */
    private function cache($req){
        if($this->cache && !$this->debug){
            $filter = $this->filter[$this->filter_name];
            $cache_md5 = md5(serialize($this->param));
            if(isset($filter['cache']) && $filter['cache']){
                Cache::set($this->filter_name.$cache_md5,$req,$filter['cache']);
            }
        }
    }

    /**
     * 请求错误情况下的回调
     * @param $code
     * @param string $message
     */
    protected function wrong($code,$message='')
    {
        $this->response([],strval($code),$message);
    }

    /**
     * 一般情况下的回调
     * @param array $data
     * @param int $code
     * @param string $message
     */
    protected function response($data=[],$code=200,$message=''){
        $req['code'] = $code;
        $req['data'] = $data;
        $req['message'] = !empty($message)?$message:LangService::message($code);
        $this->send($req);
        $this->cache($req);
        die();
    }

    /**
     * 回调数据给客户端，并运行后置中间件
     * @param $req
     */
    private function send($req){
        Response::create($req, 'json', "200")->send();
        if(function_exists('fastcgi_finish_request')){
            fastcgi_finish_request();
        }else{
            die();
        }
        $this->middleware('after');
    }

    /**
     * 方法不存在时的空置方法
     */
    public function __empty(){
        $this->wrong(500);
    }
}