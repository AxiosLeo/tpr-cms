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
use library\connector\Mysql;

class Menu extends AdminLogin
{
    /**
     * 菜单管理
     * @return mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function index()
    {
        $Menu = new MenuModel();
        $parent_menu = $Menu->getMenu();
        $this->assign('parent_menu', $parent_menu);

        $node_count = Mysql::name('menu')->count();
        $limit = 10;
        $pages = ($node_count % $limit) ? 1 + $node_count / $limit : $node_count / $limit;
        $this->assign('pages', $pages);

        return $this->fetch('index');
    }

    /**
     * 添加菜单
     * @return mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     * @throws \tpr\framework\Exception
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

            if (Mysql::name('menu')->insertGetId($data)) {
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
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function getMenu()
    {
        $this->response(MenuModel::model()->getMenuTree());
    }

    /**
     * 编辑菜单信息
     * @return mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     * @throws \tpr\framework\Exception
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

            if (Mysql::name('menu')->where('id', $id)->update($this->param)) {
                $this->success('更新成功', '', $this->param);
            } else {
                $this->error('更新失败');
            }
        }

        $menu = Mysql::name('menu')->where('id', $id)->find();
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
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     * @throws \tpr\framework\Exception
     */
    public function delete()
    {
        $id = $this->request->param('id', 0);
        if (Mysql::name('menu')->where('id', $id)->delete()) {
            $this->success("删除成功");
        } else {
            $this->error("操作失败");
        }
    }

    /**
     * 获取所有菜单
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     * @throws \tpr\framework\Exception
     */
    public function getAllMenu()
    {
        $page = $this->request->param('page', 1);
        $limit = $this->request->param('limit', 10);

        $nodes = Mysql::name('menu')->page($page)->limit($limit)->select();
        $node_count = Mysql::name('menu')->count();

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