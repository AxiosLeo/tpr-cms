<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */

namespace tpr\admin\system\controller;

use tpr\admin\common\controller\AdminLogin;
use think\Db;

class Menu extends AdminLogin
{
    public function index()
    {
        $Menu = new \tpr\admin\common\model\Menu();
        $parent_menu = $Menu->getMenu();
        $this->assign('parent_menu', $parent_menu);

        $node_count = Db::name('menu')->count();
        $limit = 10;
        $pages = ($node_count % $limit) ? 1 + $node_count / $limit : $node_count / $limit;
        $this->assign('pages', $pages);

        return $this->fetch('index');
    }

    public function test()
    {
        dump(\tpr\admin\common\model\Menu::model()->getMenu());
    }

    public function getMenu()
    {
        $this->response(\tpr\admin\common\model\Menu::model()->getMenuTree());
    }

    public function updateMenu()
    {
        $id = isset($this->param['id']) ? $this->param['id'] : 0;
        if (!empty($id)) {
            $this->param['update_at'] = time();
            if ($this->param['parent_id'] == $id) {
                $this->error("当前菜单与父级菜单相同<br />请选择其它父级菜单");
            }

            if (Db::name('menu')->where('id', $id)->update($this->param)) {
                $this->success('更新成功', '', $this->param);
            } else {
                $this->error('更新失败');
            }
        } else {
            $this->param['update_at'] = time();

            if (Db::name('menu')->insertGetId($this->param)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        }
    }

    public function deleteMenu()
    {
        $id = $this->param['id'];
        if (Db::name('menu')->where('id', $id)->delete()) {
            $this->success("删除成功");
        } else {
            $this->error("操作失败");
        }
    }

    public function getAllMenu()
    {
        $page = isset($this->param['page']) && !empty($this->param['page']) ? $this->param['page'] : 1;
        $limit = isset($this->param['limit']) && !empty($this->param['limit']) ? $this->param['limit'] : 10;

        $nodes = Db::name('menu')->page($page)->limit($limit)->select();
        $node_count = Db::name('menu')->count();

        $pages = ($node_count % $limit) ? 1 + $node_count / $limit : $node_count / $limit;

        $req = [
            'total' => $node_count,
            'node' => $nodes,
            'page' => $page,
            'pages' => $pages,
            'limit' => $limit
        ];
        $this->response($req);
    }
}