<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/30 下午1:55
 */

namespace tpr\admin\common\model;

use library\logic\NodeLogic;
use library\connector\Mysql;

class MenuModel
{
    public $name = 'menu';

    public static function model()
    {
        return new self();
    }

    /**
     * @param int $parent_id
     * @param $role_id
     * @return array|bool|mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function menus($parent_id = 0 , $role_id)
    {
        $tmp = Mysql::name('menu')->where('parent_id', $parent_id)
            ->order('sort asc')
            ->select();
        $role_node_array = NodeLogic::roleNode($role_id);

        $list = [];
        if($role_id != 1){
            foreach ($tmp as $t){
                $mca = $t['module'] . '/' . $t['controller'] . '/' . $t['func'];
                if(in_array($mca , $role_node_array) || $mca == 'index/index/index' || $mca=='index/index/main'){
                    $list[] = $t;
                }
            }
        }else{
            $list = $tmp;
        }

        return $list;
    }

    /**
     * @param bool $only_parent
     * @return bool|mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function getMenu($only_parent = false)
    {
        $menus = Mysql::name('menu')->where('parent_id', 0)
            ->field('id,title ,title as name ,icon,parent_id,module , controller , func , sort')->order('sort')->select();
        if (!$only_parent) {
            foreach ($menus as &$m) {
                $m['children'] = Mysql::name('menu')->where('parent_id', $m['id'])
                    ->field('id,title ,title as name ,parent_id,icon,module , controller , func , sort')->order('sort')->select();
                $m['spread'] = true;
            }
        }

        return $menus;
    }

    /**
     * @param int $parent_id
     * @param int $role_id
     * @return bool|mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public function getMenuTree($parent_id = 0, $role_id = 0)
    {
        return $this->menuTree($parent_id, $role_id);
    }

    /**
     * @param int $parent_id
     * @param int $role_id
     * @return bool|mixed
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    private function menuTree($parent_id = 0, $role_id = 0)
    {
        $query = Mysql::name('menu')->where('parent_id', $parent_id);

        if ($role_id) {
            $query->join("__ROLE_NODE__ rn", 'rn.menu_id=menu.id', 'left');
        }
        $query->field('id,title ,title as name ,icon , parent_id,module , controller , func , sort');

        $menu = $query->order('sort asc')->select();
        foreach ($menu as &$m) {
            $m['spread'] = true;
            $m['children'] = $this->menuTree($m['id'], $role_id);
        }
        return $menu;
    }

}