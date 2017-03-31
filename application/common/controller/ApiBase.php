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
use think\Db;
use think\Env;
use think\Request;
use think\Response;
use think\Session;

class ApiBase extends Controller{

    protected $method;

    protected $param;

    protected $code ;

    protected $message;

    protected $filter;

    protected $route;

    protected $type;

    protected $ip;

    protected $path;

    protected $cache = false;

    protected $filter_name;

    protected $identify = '';

    protected $debug;

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->message = $this->request->method();
        $this->param   = $this->request->param();
        $this->route   = $this->request->route();
        $this->filter  = Config::get('filter');
        $route         = $this->request->routeInfo();
        $this->route   = isset($route['rule'][0]) && !empty($route['rule'][0]) ? $route['rule'][0]:'';
        $this->path    = $this->request->path();
        $this->debug   = Env::get("debug.status");
        $this->filter();
        $this->middleware('before');
    }

    protected function filter(){
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
            $this->identify = session_id().$this->filter_name;
            if(isset($filter['cache']) && !$this->debug){
                $this->cache = true;
                $cache_md5 = Cache::get($this->identify."_md5");
                $param_md5 = md5(serialize($this->param));
                if(!empty($cache_md5) && $cache_md5==$param_md5){
                    $response_cache = Cache::get($this->identify);
                    if(!empty($response_cache)){
                        $this->send($response_cache);
                    }
                }
            }

            if(isset($filter['mobile']) && $filter['mobile']===true){
                if(!$this->request->isMobile()){
                    $this->wrong(406);
                }
            }

            $Validate = validate($filter['validate']);

            $check = isset($filter['scene'])?$Validate->scene($filter['scene'])->check($this->param):$Validate->check($this->param);
            if(!$check){
                return $this->wrong(400,$Validate->getError());
            }
        }
        return true;
    }

    private function middleware($when='before'){
        $middleware = Config::get('middleware.'.$when);
        if(!empty($this->route) && isset($middleware[$this->route])){
            $m = $middleware[$this->route];

        }else if(isset($this->filter[$this->path])){
            $m = $middleware[$this->path];
        }else{
            $m = [];
        }
        if(!empty($m)){
            $Middleware = middleware($m['middleware']);
            call_user_func([$Middleware,$m['func']]);
        }
    }

    private function cache($req){
        if($this->cache && !$this->debug){
            $filter = $this->filter[$this->filter_name];
            $cache_md5 = md5(serialize($this->param));
            Cache::set($this->identify."_md5",$cache_md5);
            if($filter['cache']){
                Cache::set(session_id().$this->identify,$req,$filter['cache']);
            }else{
                Cache::set(session_id().$this->identify,$req);
            }
        }
    }

    protected function wrong($code,$message='')
    {
        $this->response([],strval($code),$message);
    }

    protected function response($data,$code=200,$message=''){
        $req['code'] = $code;
        $req['data'] = $data;
        $req['message'] = !empty($message)?$message:LangService::trans()->message($code);
        $this->cache($req);
        $this->send($req);
    }

    private function send($req){
        Response::create($req, 'json', "200")->send();
        fastcgi_finish_request();
        $this->middleware('after');
    }

    public function __empty(){
        $this->wrong(500);
    }
}