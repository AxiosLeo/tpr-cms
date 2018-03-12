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
use think\Db;
use think\Model;

class MenuModel extends Model
{
    public $name = 'menu';

    function __construct($data = [])
    {
        parent::__construct($data);
    }

    public static function model()
    {
        return new self();
    }

    /**
     * @param int $parent_id
     * @param $role_id
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function menus($parent_id = 0 , $role_id)
    {
        $tmp = Db::name('menu')->where('parent_id', $parent_id)
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
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMenu($only_parent = false)
    {
        $menus = $this->where('parent_id', 0)
            ->field('id,title ,title as name ,icon,parent_id,module , controller , func , sort')->order('sort')->select();
        if (!$only_parent) {
            foreach ($menus as &$m) {
                $m['children'] = $this->where('parent_id', $m['id'])
                    ->field('id,title ,title as name ,parent_id,icon,module , controller , func , sort')->order('sort')->select();
                $m['spread'] = true;
            }
        }

        return $menus;
    }

    /**
     * @param int $parent_id
     * @param int $role_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMenuTree($parent_id = 0, $role_id = 0)
    {
        return $this->menuTree($parent_id, $role_id);
    }

    /**
     * @param int $parent_id
     * @param int $role_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function menuTree($parent_id = 0, $role_id = 0)
    {
        $this->where('parent_id', $parent_id);

        if ($role_id) {
            $this->join("__ROLE_NODE__ rn", 'rn.menu_id=menu.id', 'left');
        }
        $this->field('id,title ,title as name ,icon , parent_id,module , controller , func , sort');

        $menu = $this->order('sort asc')->select();
        foreach ($menu as &$m) {
            $m['spread'] = true;
            $m['children'] = $this->menuTree($m['id'], $role_id);
        }
        return $menu;
    }

}