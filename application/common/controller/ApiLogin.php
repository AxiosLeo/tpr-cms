<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/11 14:47
 */
namespace app\common\controller;

use app\common\service\LangService;
use app\common\service\TokenService;
use think\Request;

class ApiLogin extends ApiBase{
    protected $user ;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->commonFilter('login');//公共过滤
        $this->checkToken();
    }

    protected function checkToken(){
        if(isset($this->param['token']) && !empty($this->param['token'])){
            $token = $this->param['token'];
        }else{
            $token =$this->request->header("X-Client-Token");
        }
        if(empty($token)){
            $this->wrong(400,LangService::trans("token@not@exits"));
        }

        $result = TokenService::checkToken($token);
        if(is_int($result)){
            $this->wrong($result);
        }
        $this->user = $result;

        TokenService::updateTokenExpire($token);
    }
}