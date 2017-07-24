<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 14:36
 */

namespace admin\user\controller;

use admin\common\controller\HomeLogin;
use think\Db;

class Index extends HomeLogin
{
    public function profile()
    {
        $role = Db::name('role')->where('id', $this->user['role_id'])->find();
        $this->assign('role_name', $role['role_name']);
        return $this->fetch('profile');
    }

    public function password()
    {
        if ($this->request->isPost()) {
            //check password confirm
            if ($this->param['password'] != $this->param['password_confirm']) {
                $this->error('确认密码与新密码不匹配');
            }
            if ($this->param['password'] == $this->param['old_password']) {
                $this->error('新密码与旧密码不能相同');
            }

            $Validate = new \admin\user\validate\Admin();
            if (!$Validate->scene('password')->check($this->param)) {
                $this->error($Validate->getError());
            }

            //check old password
            $user = Db::name('admin')->where('id', $this->user['id'])->find();
            $old_password = make_password($this->param['old_password'], $user['security_id']);
            if ($old_password != $user['password']) {
                $this->error('密码不正确');
            }

            $password = make_password($this->param['password'], $user['security_id']);

            $user['password'] = $password;
            $user['update_at'] = time();
            $result = Db::name('admin')->where('id', $user['id'])->update($user);
            if ($result) {
                $this->success('操作成功,请重新登录', url('user/login/logout'));
            } else {
                $this->error('操作失败');
            }

            $this->error('', '', $this->param);
        }
        return $this->fetch('password');
    }
}