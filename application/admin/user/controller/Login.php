<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 14:00
 */

namespace tpr\admin\user\controller;

use tpr\admin\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Env;
use think\Cache;
use think\Tool;

class Login extends AdminBase
{
    private $ip;

    /**
     * 登陆
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        if (is_user_login()) {
            $this->redirect("index/index/index");
        }
        if($this->request->isPost()){
            $this->checkIp();

            $username = $this->param['username'];
            $password = $this->param['password'];
            $verify = $this->param['verify'];

            if (!captcha_check($verify)) {
                $this->error("验证码不正确", captcha_src());
            };

            $user = Db::name('admin')->where('username', $username)->find();
            if (empty($user)) {
                $this->error("用户不存在", captcha_src());
            }

            $password = make_password($password, $user['security_id']);
            if ($password != $user['password']) {
                $this->error('密码错误！' . $password, captcha_src());
            }

            $user['token'] = Tool::uuid();
            $user['last_login_ip'] = $this->ip;
            $user['last_login_time'] = time();
            Db::name('admin')->where('id', $user['id'])->update($user);
            unset($user['password']);
            unset($user['security_id']);
            user_save($user);

            /*** 单点登录，记录token ***/
            $expire = intval(Config::get('web.token', 172800));
            Cache::set("admin_login_token" . $user['username'], $user['token'], $expire);

            $this->success("操作成功", url('index/index/index'));
        }
        return $this->fetch('login');
    }

    /**
     * 登出
     * @except
     */
    public function logout()
    {
        clear_user_login();
        $this->redirect("user/login/index");
    }

    protected function checkIp()
    {
        $this->ip = Tool::getClientIp();
        $env_allow_ip = Env::get("web.allow_ip", "0.0.0.0");

        $allow_ip = explode(',', $env_allow_ip);

        if ($env_allow_ip != "0.0.0.0" && !in_array($this->ip, $allow_ip) && !in_array("0.0.0.0", $allow_ip)) {
            $this->error("非法登陆<br />请将" . $this->ip . "添加进白名单", captcha_src());
        }
    }
}