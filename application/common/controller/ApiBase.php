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

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->message = $this->request->method();
        $this->param   = $this->request->param();
        $this->route   = $this->request->route();
        $this->filter  = Config::get('filter');
        $route         = $this->request->routeInfo();
        $this->route   = $route['rule'][0];
        $this->filter();
    }

    protected function filter(){
        if(isset($this->filter[$this->route])){

            $filter = $this->filter[$this->route];
            if(isset($filter['mobile']) && $filter['mobile']===true){
                if(!$this->request->isMobile()){
                    $this->wrong(406);
                }
            }
            $Validate = validate($filter['validate']);

            $check = isset($filter['scene'])?$Validate->scene($filter['scene'])->check($this->param):$Validate->check($this->param);
            if(!$check){
                return $this->response($Validate->getError(),"400");
            }
        }
        return true;
    }

    protected function wrong($code)
    {
        $this->response("",strval($code));
    }

    protected function response($data,$code=200){
        $req['code'] = $code;
        $req['data'] = $data;
        $req['message'] = LangService::trans()->message($code);
        Response::create($req,'json',"200")->send();
    }

    public function __empty(){
        $this->wrong(500);
    }
}