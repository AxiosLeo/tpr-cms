<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */

namespace tpr\admin\system\controller;

use library\logic\NodeLogic;
use tpr\admin\common\controller\AdminLogin;
use tpr\admin\common\model\MenuModel;
use think\Db;

class Menu extends AdminLogin
{
    /**
     * 菜单管理
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $Menu = new MenuModel();
        $parent_menu = $Menu->getMenu();
        $this->assign('parent_menu', $parent_menu);

        $node_count = Db::name('menu')->count();
        $limit = 10;
        $pages = ($node_count % $limit) ? 1 + $node_count / $limit : $node_count / $limit;
        $this->assign('pages', $pages);

        return $this->fetch('index');
    }

    /**
     * 添加菜单
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $parent_id = $this->request->param('parent_id', 0);
            $path = $this->param['node_path'];
            list($this->param['module'], $this->param['controller'], $this->param['func']) = explode('/', $path);

            $this->param['update_at'] = time();

            $data = [
                'icon' => $this->param['icon'],
                'title' => $this->param['title'],
                'parent_id' => $parent_id,
                'module' => $this->param['module'],
                'controller' => $this->param['controller'],
                'func' => $this->param['func'],
                'sort' => $this->param['sort']
            ];

            if (Db::name('menu')->insertGetId($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        }

        $parent_menu = MenuModel::model()->getMenu();
        $this->assign('parent_menu', $parent_menu);

        $result = NodeLogic::adminNode(false);
        $node_list = $result['list'];
        $this->assign('node_list', $node_list);

        return $this->fetch();
    }


    /**
     * 获取菜单数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMenu()
    {
        $this->response(MenuModel::model()->getMenuTree());
    }

    /**
     * 编辑菜单信息
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $id = $this->request->param('id', 0);
        if ($this->request->isPost()) {
            $parent_id = $this->request->param('parent_id', 0);
            $path = $this->param['node_path'];
            list($this->param['module'], $this->param['controller'], $this->param['func']) = explode('/', $path);

            $this->param['update_at'] = time();
            if ($parent_id == $id) {
                $this->error("当前菜单与父级菜单相同<br />请选择其它父级菜单");
            }

            if (Db::name('menu')->where('id', $id)->update($this->param)) {
                $this->success('更新成功', '', $this->param);
            } else {
                $this->error('更新失败');
            }
        }

        $menu = Db::name('menu')->where('id', $id)->find();
        $this->assign('data', $menu);

        $parent_menu = MenuModel::model()->getMenu();
        $this->assign('parent_menu', $parent_menu);

        $result = NodeLogic::adminNode(false);
        $node_list = $result['list'];
        $this->assign('node_list', $node_list);

        return $this->fetch('edit');
    }

    /**
     * 删除菜单
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete()
    {
        $id = $this->request->param('id', 0);
        if (Db::name('menu')->where('id', $id)->delete()) {
            $this->success("删除成功");
        } else {
            $this->error("操作失败");
        }
    }

    /**
     * 获取所有菜单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllMenu()
    {
        $page = $this->request->param('page', 1);
        $limit = $this->request->param('limit', 10);

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