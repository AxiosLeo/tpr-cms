<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 13:09
 */
namespace admin\common\model;

use think\Model;

class Menu extends Model{
    public $name = 'menu';

    function __construct($data = [])
    {
        parent::__construct($data);
    }

    public static function model(){
        return new self();
    }

    public function menus($parent_id=0,$all=true){
        $this->alias('menu');

        if(!$all){
            $this->where('show',0);
        }

        $this->join("__ROLE_NODE__ rn",'rn.menu_id=menu.id','left')
            ->field('menu.* ');

        $list =  $this->where('parent_id',$parent_id)->order('sort asc')->select();

        return $list;
    }

    public function getMenu($only_parent = false){
        $menus = $this->where('parent_id',0)
            ->field('id,title ,title as name ,icon,parent_id,module , controller , func , sort')->order('sort')->select();
        if(!$only_parent){
            foreach ($menus as &$m){
                $m['children'] = $this->where('parent_id',$m['id'])
                    ->field('id,title ,title as name ,parent_id,icon,module , controller , func , sort')->order('sort')->select();
                $m['spread'] = true;
            }
        }

        return $menus;
    }
}