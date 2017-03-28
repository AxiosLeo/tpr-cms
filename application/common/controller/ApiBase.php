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
    }

    protected function filter(){
        if(!empty($this->route) && isset($this->filter[$this->route])){
            $filter = $this->filter[$this->route];

        }else if(isset($this->filter[$this->path])){
            $filter = $this->filter[$this->path];
        }else{
            $filter = [];
        }
        if(!empty($filter)){
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
        Response::create($req,'json',"200")->send();
    }

    public function __empty(){
        $this->wrong(500);
    }
}