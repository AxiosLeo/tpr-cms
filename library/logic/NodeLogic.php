<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/29 15:49
 */
namespace library\logic;

use think\Doc;

class NodeLogic{
    public static function adminNode($class_path = [] ,$page = 1 , $limit = 10){
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
        return [
            'list' => $page ? array_slice($node_list , ($page-1)*$limit,$limit) : $node_list,
            'count'=>$n
        ];
    }
}