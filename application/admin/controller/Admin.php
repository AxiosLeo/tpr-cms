<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:05
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use app\users\validate\AdminValidate;
use think\Request;
use think\Db;
class Admin extends HomeLogin {
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-cog');
    }

    public function index(){
        $users = Db::name('admin')->alias('admin')
            ->join('__ROLE__ r','r.id=admin.role_id','left')
            ->field('admin.*,r.role_name as role_name')
            ->select();
        return $this->fetch('index',['list'=>$users]);
    }

    public function add(){
        if($this->request->isPost()){
            $Validate = new AdminValidate();
            if($Validate->scene('admin.add')->check($this->param)){
                $this->error($Validate->getError());
            }
            $insert = [
                'security_id'=>strtoupper(uniqid()),
                'role_id'=>$this->param['role_id'],
                'username'=>$this->param['username'],
            ];
            $insert['password'] = make_password($this->param['password'],$insert['security_id']);

            if(Db::name('admin')->insertGetId($insert)){
                $this->success("操作成功" ,url('admin/admin/index'));
            }else{
                $this->error("操作失败");
            }
        }

        $this->assign("roles",Db::name('role')->select());

        return $this->fetch('add');
    }

    public function edit(){

        $id = $this->param['id'];

        if($this->request->isPost()){
            $Validate = new AdminValidate();
            if($Validate->scene('admin.edit')->check($this->param)){
                $this->error($Validate->getError());
            }
            $update = [
                'role_id'=>$this->param['role_id'],
                'username'=>$this->param['username'],
            ];

            if(Db::name('admin')->where('id',$id)->update($update)){
                $this->success("操作成功" ,url('admin/admin/index'));
            }else{
                $this->error("操作失败");
            }
        }

        $data = Db::name('admin')->find($id);
        $this->assign("roles",Db::name('role')->select());

        return $this->fetch('edit',['data'=>$data]);
    }

    public function delete(){
        $id = $this->param['id'];

        if(Db::name('admin')->where('id',$id)->delete()){
            $this->success('操作成功',url('admin/admin/index'));
        }else{
            $this->error("操作失败");
        }
    }
}