<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 17:11
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use think\Request;
use think\Db;

class Menu extends HomeLogin{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-cog');
    }

    public function index(){
        $menu = [];
        $this->makeMenuTree(0,$menu,true);
        return $this->fetch('index',['list'=>$menu]);
    }

    public function add(){
        if($this->request->isPost()){
            if($this->param['parent_id']==0 && $this->param['menu_fast']==1){
                $this->error('父级菜单不能设置为快捷菜单');
            }
            $insert = [
                'title'=>$this->param['title'],
                'icon'=>$this->param['icon'],
                'parent_id'=>$this->param['parent_id'],
                'controller'=>$this->param['controller'],
                'func'=>$this->param['func'],
                'show'=>$this->param['show'],
                'sort'=>$this->param['sort'],
                'module'=>"admin",
                'menu_fast'=>$this->param['menu_fast']
            ];
            if(Db::name('menu')->insertGetId($insert)){
                $this->success("操作成功",url("admin/menu/index"));
            }else{
                $this->error("操作失败");
            }
        }
        $menu = [];
        $this->makeMenuTree(0,$menu,true);
        return $this->fetch('add',['parent'=>$menu]);
    }

    public function edit(){
        $id=$this->param['id'];

        if($this->request->isPost()){
            if($this->param['parent_id']==0 && $this->param['menu_fast']==1){
                $this->error('父级菜单不能设置为快捷菜单');
            }
            $update = [
                'title'=>$this->param['title'],
                'icon'=>$this->param['icon'],
                'parent_id'=>$this->param['parent_id'],
                'controller'=>$this->param['controller'],
                'func'=>$this->param['func'],
                'show'=>$this->param['show'],
                'sort'=>$this->param['sort'],
                'menu_fast'=>$this->param['menu_fast']
            ];
            if(Db::name('menu')->where('id',$id)->update($update)){
                $this->success("操作成功",url("admin/menu/index"));
            }else{
                $this->error("操作失败");
            }
        }

        $data = Db::name('menu')->find($id);
        $menu = [];
        $this->makeMenuTree(0,$menu,true);
        return $this->fetch('edit',['data'=>$data,'parent'=>$menu]);
    }

    public function delete(){
        $id=$this->param['id'];
        if(Db::name('menu')->where('id',$id)->delete()){
            $this->success("操作成功",url("admin/menu/index"));
        }else{
            $this->error("操作失败");
        }
    }
}