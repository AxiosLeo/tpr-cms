<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 14:00
 */
namespace admin\user\controller;

use admin\common\controller\HomeBase;
use axios\tpr\service\RedisService;
use axios\tpr\service\ToolService;
use think\Config;
use think\Db;
use think\Session;
use think\Env;

class Login extends HomeBase{
    private $ip;
    public function index(){
        if(is_user_login()){
            $this->redirect("index/index/index");
        }
        return $this->fetch('login');
    }

    public function logout(){
        Session::delete('user');
        $this->redirect("user/login/index");
    }

    public function doLogin(){
        $this->checkIp();

        $username = $this->param['username'];
        $password = $this->param['password'];
        $verify   = $this->param['verify'];

        if(!captcha_check($verify)){
            $this->error("验证码不正确",captcha_src());
        };

        $user = Db::name('admin')->where('username',$username)->field('id,username,password,security_id,role_id')->find();
        if(empty($user)){
            $this->error("用户不存在",captcha_src());
        }

        $password = make_password($password,$user['security_id']);
        if ($password!=$user['password']) {
            $this->error('密码错误！'.$password,captcha_src());
        }

        $user['token'] = ToolService::token();
        $user['last_login_ip'] = $this->ip;
        $user['last_login_time'] = time();
        Db::name('admin')->where('id',$user['id'])->update($user);
        unset($user['password']);
        unset($user['security_id']);
        Session::set('user',$user);
        $setting_token = Config::get('setting.token');
        $expire = isset($setting_token['token_expire'])?$setting_token['token_expire']:36000;
        RedisService::redis()->switchDB(1)->set("admin_login_token".$user['username'],$user['token'],$expire);

        $this->success("操作成功",'/admin.php');
    }

    public function checkIp(){
        $this->ip = get_client_ip();
        $env_allow_ip = Env::get("auth.allow_ip");

        $allow_ip = explode(',',$env_allow_ip);

        if($env_allow_ip!="0.0.0.0" && !in_array($this->ip,$allow_ip) && !in_array("0.0.0.0",$allow_ip)){
            $this->error("非法登陆<br />请将".$this->ip."添加进白名单",captcha_src());
        }
    }
}