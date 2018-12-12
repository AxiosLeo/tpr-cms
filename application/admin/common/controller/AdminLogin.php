<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:56
 */

namespace tpr\admin\common\controller;

use library\connector\Mysql;
use think\facade\Cache;
use think\facade\Env;

class AdminLogin extends AdminBase
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        if (!is_user_login()) {
            $this->redirect("user/login/index");
        } else {
            $this->user = user_info();
            $this->assign('user', $this->user);
        }
        $this->checkAuth();

        /***
         * redis token 单点登录
         ***/
        $token_key = "admin_login_token" . $this->user['username'];
        $token = Cache::get($token_key, '');

        if ($token != $this->user['token']) {
            $this->error("您的账号已在其它地方登陆", url("user/login/logout"));
        } else {
            $expire = intval(Env::get('web.token', 172800));
            Cache::set($token_key, $token, $expire);
        }
    }

    /**
     * @return bool
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function checkAuth(){
        $path = $this->request->module() . '/' . strtolower($this->request->controller()) . '/' . $this->request->action();
        if($path == 'index/index/index' || $path == 'index/index/main' ){
            return true;
        }

        $role_id = user_info('role_id');
        if($role_id === 1){
            return true;
        }

        $exist = Mysql::name('role_node')
            ->where('role_id',$role_id)
            ->where('node_path',$path)
            ->where('disabled',0)
            ->count();

        $auth = $exist ? 1 : 0;

        if(!$auth){
            $this->request->isPost() ? $this->error('无操作权限','',$this->request->param()) : $this->redirect('index/message/none');
        }
        return false;
    }
}