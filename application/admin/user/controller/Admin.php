<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:05
 */

namespace tpr\admin\user\controller;

use tpr\admin\common\controller\AdminLogin;
use think\Db;

class Admin extends AdminLogin
{
    public function index()
    {
        $count = Db::name('admin')->count();
        $limit = 10;
        $this->assign('pages', ($count % $limit) ? 1 + $count / $limit : $count / $limit);
        return $this->fetch('index');
    }

    public function getAdmin()
    {
        $page = isset($this->param['page']) && !empty($this->param['page']) ? $this->param['page'] : 1;
        $limit = isset($this->param['limit']) && !empty($this->param['limit']) ? $this->param['limit'] : 10;

        $admin = Db::name('admin')->alias('admin')
            ->join('__ROLE__ r', 'r.id=admin.role_id', 'left')
            ->field('admin.* , r.role_name')->page($page)->limit($limit)->order('role_id , id')->select();
        foreach ($admin as &$a) {
            $a['last_login_time'] = date("Y-m-d H:i:s", $a['last_login_time']);
        }
        $this->response($admin);
    }

    public function edit()
    {
        $id = $this->param['id'];

        if ($this->request->isPost()) {
            $Validate = new \tpr\admin\user\validate\Admin();
            if (!$Validate->scene('update')->check($this->param)) {
                $this->error($Validate->getError());
            }
            $this->param['update_at'] = time();
            if (Db::name('admin')->where('id', $id)->update($this->param)) {
                $this->success(lang('success!'));
            } else {
                $this->error(lang('error!'));
            }
        }

        $admin = Db::name('admin')->where('id', $id)->find();
        $this->assign('data', $admin);

        $roles = Db::name('role')->select();
        $this->assign('roles', $roles);

        return $this->fetch('edit');
    }
}