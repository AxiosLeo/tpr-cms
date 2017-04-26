<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:07
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use think\Db;
use think\Request;

class Role extends HomeLogin{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-cog');
    }

    public function index(){
        $list = Db::name('role')->select();
        return $this->fetch('index',['list'=>$list]);
    }

    public function add(){
        if($this->request->isPost()){
            if(Db::name('role')->where('role_name',$this->param['role_name'])->count()){
                $this->error("该角色已存在");
            }
            $insert = [
                'role_name'=>$this->param['role_name']
            ];
            $menu = $this->param['menu'];
            $id = Db::name('role')->insertGetId($insert);
            if(!$id){
                $this->error("操作失败");
            }

            foreach ($menu as $m){
                $insert_node = ['role_id'=>$id,'menu_id'=>$m];
                Db::name('role_node')->insert($insert_node);
            }

            $this->success("操作成功",url('admin/role/index'));
        }

        $menu = [];
        $this->makeMenuTree(0,$menu);
        $this->assign('menu',$menu);

        return $this->fetch('add');
    }

    public function edit()
    {
        $id = $this->param['id'];
        if($this->request->isPost()){
            $update = [
                'role_name'=>$this->param['role_name']
            ];
            $menu = $this->param['menu'];
            $old_menu = Db::name('role_node')->where('role_id',$id)->select();
            $old_menu_array = [];$n=0;

            foreach ($old_menu as $om){
                if(!in_array($om['menu_id'],$menu)){
                    Db::name('role_node')->where('role_id',$id)->where('menu_id',$om['menu_id'])->delete();
                }else{
                    $old_menu_array[$n++] = $om['menu_id'];
                }
            }

            foreach ($menu as $m){
                if(!in_array($m,$old_menu_array)){
                    $insert_node = ['role_id'=>$id,'menu_id'=>$m];
                    Db::name('role_node')->insert($insert_node);
                }
            }

            Db::name('role')->where('id',$id)->update($update);
            $this->success("操作成功",url('admin/role/index'));
        }

        $data = Db::name('role')->find($id);

        $menu = [];
        $this->makeMenuTree(0,$menu);
        $this->assign('menu',$menu);

        $old_menu = Db::name('role_node')->where('role_id',$id)->select();
        $old_menu_array = [];$n=0;

        foreach ($old_menu as $om){
            $old_menu_array[$n++] = $om['menu_id'];
        }
        $this->assign('old_menu',$old_menu_array);

        return $this->fetch('edit',['data'=>$data]);
    }

    public function delete(){
        $id = $this->param['id'];

        Db::name('admin')->where('role_id',$id)->update(['role_id'=>0]);

        if(Db::name('role')->where('id',$id)->delete()){
            $this->success("操作成功",url('admin/role/index'));
        }else{
            $this->error("操作失败",url('admin/role/index'));
        }
    }
}