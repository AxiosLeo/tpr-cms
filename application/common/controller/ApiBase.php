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
use think\Request;
use think\Response;

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

    protected $identify = '';

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
        $this->filter();
        $this->middleware('before');
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

    protected function filter(){
        if(!empty($this->route) && isset($this->filter[$this->route])){
            $this->identify = $this->route;
            $filter = $this->filter[$this->identify];
        }else if(isset($this->filter[$this->path])){
            $this->identify = $this->path;
            $filter = $this->filter[$this->identify];
        }else{
            $filter = [];
        }

        if(!empty($filter)){
            if(isset($filter['cache'])){
                $this->cache = true;
                $response_cache = Cache::get($this->identify);
                if(!empty($response_cache)){
                    $this->send($response_cache);
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

    protected function wrong($code,$message='')
    {
        $this->response([],strval($code),$message);
    }

    protected function response($data,$code=200,$message=''){
        $req['code'] = $code;
        $req['data'] = $data;
        $req['message'] = !empty($message)?$message:LangService::trans()->message($code);
        $this->send($req);
        fastcgi_finish_request();
        $this->middleware('after');
        $filter = $this->filter[$this->identify];
        if($this->cache && $filter['cache']){
            Cache::set($this->identify,$req,$filter['cache']);
        }
    }

    private function send($req){
        Response::create($req,'json',"200")->send();
    }

    public function __empty(){
        $this->wrong(500);
    }
}