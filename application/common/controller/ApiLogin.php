<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/2 13:49
 */
namespace app\common\controller;

use axios\tpr\controller\ApiBase;
use axios\tpr\service\GlobalService;
use axios\tpr\service\LangService;
use axios\tpr\service\UserService;
use think\Validate;
use think\Request;
use think\Config;

class ApiLogin extends ApiBase{
    protected $user ;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->commonFilter('login');//公共过滤
        $this->checkToken();
    }

    protected function commonFilter($scene='logout'){
        $setting = Config::get('setting.sign');
        $timestamp_name = isset($setting['timestamp_name'])&& !empty($setting['timestamp_name'])?$setting['timestamp_name']:"t";
        $sign_name = isset($setting['sign_name'])&& !empty($setting['sign_name'])?$setting['sign_name']:"sign";
        $rules = [
            'lang' => ['in:zh-cn,en-us'],
            'token' =>['regex:/^([a-z]|[0-9])*$/i']
        ];
        $message = [
            'token.regex'    =>'token@format@error ',
        ];
        $message[$timestamp_name.".length"] = "timestamp@length@error";
        $message[$timestamp_name.".number"] = "timestamp@is not@number";
        $message[$sign_name.".length"] = "sign@length@error";
        $message[$sign_name.".regex"] = "sign@regex@error";
        $rules[$timestamp_name] = ['length:10','number'];
        $rules[$sign_name] = ['length:32','regex:/^([a-z]|[0-9])*$/i'];
        $Validate = new Validate($rules,$message);
        $Validate->scene('logout', [$timestamp_name,$sign_name,'lang']);
        $Validate->scene('login', [$timestamp_name,$sign_name,'lang','token']);

        $check = $Validate->scene($scene)->check($this->param);
        if(!$check){
            $this->wrong(400,LangService::trans($Validate->getError()));
        }
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

        $result = UserService::checkToken($token);
        if(is_int($result)){
            $this->wrong($result);
        }
        GlobalService::set('users_token',$token);
        $this->user = $result;

        UserService::updateTokenExpire($token);
    }
}