<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 16:21
 */
namespace app\common\controller;

use axios\tpr\service\RedisService;
use think\Request;
use think\Config;
class HomeLogin extends HomeBase {
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        if(!is_user_login()){
            $this->redirect("admin/login/index");
        }else{
            $this->user = user_info();
            $this->assign('user',$this->user);
        }

        $token = RedisService::redis()->switchDB(1)->get("admin_login_token".$this->user['username']);

        if($token!=$this->user['token']){
            $this->error("您的账号已在其它地方登陆",url("admin/login/logout"));
        }else{
            $expire = Config::get('setting.token.token_expire');
            RedisService::redis()->switchDB(1)->set("admin_login_token".$this->user['username'],$token,$expire);
        }

    }
}