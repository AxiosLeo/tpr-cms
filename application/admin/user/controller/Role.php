<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:07
 */

namespace tpr\admin\user\controller;

use tpr\admin\common\controller\AdminLogin;
use think\Db;

class Role extends AdminLogin
{
    public function index()
    {
        if($this->request->isPost()){
            $roles = Db::name('role')->select();
            $count = Db::name('role')->count();

            foreach ($roles as &$r) {
                $r['admin_number'] = Db::name('admin')->where('role_id', $r['id'])->count();
            }

            $this->tableData($roles, $count);
        }

        return $this->fetch('index');
    }

    public function edit(){
        $id = $this->request->param('id',0);

        if($this->request->isPost()){
            $update = $this->param;

            //tpr-framework1.0.18+ 会自动过滤无效字段
            if(Db::name('role')->where('id',$id)->update($update)){
                $this->success('成功');
            }else{
                $this->error("操作失败");
            }
        }

        $role = Db::name('role')->where('id',$id)->find();

        $this->assign('data' , $role);

        return $this->fetch();
    }

}