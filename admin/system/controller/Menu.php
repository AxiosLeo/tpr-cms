<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */
namespace admin\system\controller;

use admin\common\controller\HomeLogin;
use axios\tpr\core\Result;
use think\Db;

class Menu extends HomeLogin{
    public function index(){
//        $parent_menu = \admin\common\model\Menu::model()->getMenu(true);
        $Menu = new \admin\common\model\Menu();
        $parent_menu = $Menu->getMenu(true);
        $this->assign('parent_menu',$parent_menu);
        return $this->fetch('index');
    }

    public function getMenu(){
        Result::rep(\admin\common\model\Menu::model()->getMenu());
    }

    public function updateMenu(){
        $id = $this->param['id'];

        if(!empty($id)){
            $update = [
                'parent_id'=>$this->param['parent_id'],
                'title'=>$this->param['name'],
                'icon'=>$this->param['icon'],
                'module'=>$this->param['module'],
                'controller'=>$this->param['controller'],
                'func'=>$this->param['func'],
                'sort'=>$this->param['sort'],
                'update_at'=>time()
            ];

            if(Db::name('menu')->where('id',$id)->update($update)){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }else{
            $update = [
                'parent_id'=>$this->param['parent_id'],
                'title'=>$this->param['name'],
                'icon'=>$this->param['icon'],
                'module'=>$this->param['module'],
                'controller'=>$this->param['controller'],
                'func'=>$this->param['func'],
                'sort'=>$this->param['sort'],
                'update_at'=>time()
            ];

            if(Db::name('menu')->insertGetId($update)){
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }
    }

    public function deleteMenu(){
        $id = $this->param['id'];
        if(Db::name('menu')->where('id',$id)->delete()){
            $this->success("删除成功");
        }else{
            $this->error("操作失败");
        }
    }
}