<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/29 15:49
 */
namespace library\logic;

use think\Db;
use think\Doc;

class NodeLogic{

    public static $roleNode = [];

    public static $roleId = 0;

    public static function adminNode($page = 1 , $limit = 10){
        $class_path = [];
        $dirHandle = opendir(APP_PATH);
        while (false !== ($fileName = readdir($dirHandle))) {
            $subFile = APP_PATH . $fileName;
            if (is_dir($subFile) && str_replace('.', '', $fileName) != '' && !in_array($fileName , c('deny_module_list',['common']))) {
                $class_path[] = $subFile . DS . 'controller';
            }
        }
        closedir($dirHandle);

        Doc::config($class_path,APP_PATH);
        $doc = Doc::doc();
        $node_list = []; $n = 0;

        foreach ($doc as $d){
            $methods = $d['methods'];

            foreach ($methods as $m){
                if(!isset($m['comment']['except'])){
                    $node_list[$n++] = [
                        'title'=>data($m['comment'],'title','未注释'),
                        'path'=>data($m,'path','')
                    ];
                }
            }
        }

        $node_list = $page ? array_slice($node_list , ($page-1)*$limit,$limit) : $node_list;

        $menus = Db::name('menu')->field('title , module , controller , func')->select();
        $menu_list = [];
        foreach ($menus as &$m){
            $path = $m['module'] .'/' . $m['controller'] . '/' . $m['func'];
            $menu_list[$path] = $m['title'];
        }

        foreach ($node_list as &$nl){
            if(isset($menu_list[$nl['path']])){
                $nl['title'] = $menu_list[$nl['path']];
            }
        }
        return [
            'list' => $node_list,
            'count'=>$n
        ];
    }

    public static function roleNode($role_id){
        if(self::$roleId == $role_id && !empty(self::$roleNode)){
            return self::$roleNode;
        }

        self::$roleId = $role_id;

        $role_node_list = Db::name('role_node')->where('role_id',self::$roleId)->select();

        $role_node_array = [];

        foreach ($role_node_list as $l){
            array_push($role_node_array , $l['node_path']);
        }

        self::$roleNode = $role_node_array;

        return self::$roleNode;
    }
}