<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:05
 */

namespace tpr\admin\user\controller;

use think\Tool;
use tpr\admin\common\controller\AdminLogin;
use think\Db;
use tpr\admin\common\validate\AdminValidate;

class Admin extends AdminLogin
{
    /**
     * 用户管理
     * @return mixed
     */
    public function index()
    {
        if($this->request->isPost()){
            $page = $this->request->param('page',1);
            $limit = $this->request->param('limit',10);
            $keyword = $this->request->param('keyword','');
            $admin = Db::name('admin')->alias('admin')
                ->join('__ROLE__ r', 'r.id=admin.role_id', 'left')
                ->where('admin.username' , 'like','%' . $keyword . '%')
                ->field('admin.* , r.role_name')
                ->page($page)
                ->limit($limit)
                ->order('role_id , id')
                ->select();

            $count = Db::name('admin')->alias('admin')
                ->join('__ROLE__ r', 'r.id=admin.role_id', 'left')
                ->where('admin.username' , 'like','%' . $keyword . '%')
                ->field('admin.* , r.role_name')
                ->count();

            foreach ($admin as &$a) {
                if(!empty($a['last_login_time'])){
                    $a['last_login_time'] = date("Y-m-d H:i:s", $a['last_login_time']);
                }
            }

            $this->tableData($admin , $count);
        }
        return $this->fetch('index');
    }

    /**
     * 添加管理员
     * @return mixed
     */
    public function add(){
        if( $this->request->isPost()){

            $Validate = new AdminValidate();
            if (!$Validate->scene('add')->check($this->param)) {
                $this->error($Validate->getError());
            }
            $time = time();
            $security_id = rand_upper(Tool::uuid());
            if($this->param['role_id'] == 0){
                $this->error('请选择角色');
            }

            if(Db::name('admin')->where('username',$this->param['username'])->count()){
                $this->error('用户名已存在'.$this->param['role_id']);
            }

            $data = [
                'security_id'=>$security_id,
                'role_id'=>$this->param['role_id'],
                'username'=>$this->param['username'],
                'password'=>make_password($this->param['password'], $security_id),
                'created_at'=>$time,
                'update_at'=>$time
            ];

            if (Db::name('admin')->insert($data)) {
                $this->success(lang('success!'));
            } else {
                $this->error(lang('error!'));
            }
        }

        $roles = Db::name('role')->select();
        $this->assign('roles', $roles);

        return $this->fetch();
    }

    /**
     * 编辑管理员用户信息
     * @return mixed
     */
    public function edit()
    {
        $id = $this->param['id'];

        if ($this->request->isPost()) {
            $Validate = new AdminValidate();
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

    public function delete(){
        $id = $this->request->param('id',0);
        $exist = Db::name('admin')->where('id',$id)->count();

        if(!$exist){
            $this->error('用户不存在');
        }

        if($id==1){
            $this->error("默认管理员账号不能删除<br>但可以修改username");
        }

        Db::name('admin')->where('id',$id)->delete();

        $this->success('成功');
    }


}