<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:27
 */

namespace tpr\admin\common\controller;

use library\connector\Mysql;
use tpr\framework\Request;
use tpr\framework\Cache;
use tpr\framework\Env;

class AdminLogin extends AdminBase
{
    protected $user;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

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
     * @throws \tpr\framework\Exception
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
            $this->request->isPost() ? $this->error('无操作权限','',$this->param) : $this->redirect('index/message/none');
        }
        return false;
    }
}