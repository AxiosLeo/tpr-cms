<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 16:17
 */
namespace app\admin\controller;

use app\common\controller\HomeBase;
use axios\tpr\service\RedisService;
use axios\tpr\service\ToolService;
use think\Session;
use think\Config;
use think\Env;
use think\Db;

class Login extends HomeBase {
    public function index(){
        if(is_user_login()){
            $this->redirect("admin/index/index");
        }
        return $this->fetch('index');
    }

    public function doLogin(){
        $ip =  get_client_ip();
        $allow_ip = Env::get("auth.allow_ip");
        $allow_ip = explode(',',$allow_ip);
        if($allow_ip!="0.0.0.0" && !in_array($ip,$allow_ip)){
            $this->error("非法登陆\r\n请将".$ip."添加进白名单");
        }
        if(!captcha_check($this->request->param('verify'))){
            $this->error("验证码不正确");
        };
        $username = trim($this->request->param('username'));
        $password = trim($this->request->param('password'));

        $user = Db::name("admin")->where('username',$username)->field('id,username,password,security_id,role_id')->find();
        if(empty($user)){
            $this->error("用户不存在");
        }
        $password = make_password($password,$user['security_id']);
        if ($password!=$user['password']) {
            $this->error('密码错误！'.$password);
        }

        $user['token'] = ToolService::token();
        $user['last_login_ip'] = $ip;
        $user['last_login_time'] = time();
        Db::name('admin')->where('id',$user['id'])->update($user);
        unset($user['password']);
        unset($user['security_id']);
        Session::set('user',$user);
        $expire = Config::get('setting.token.token_expire');
        RedisService::redis()->switchDB(1)->set("admin_login_token".$user['username'],$user['token'],$expire);
        $this->success("操作成功",'/admin.php');
    }

    public function logout(){
        Session::delete('user');
        $this->redirect("admin/login/index");
    }
}