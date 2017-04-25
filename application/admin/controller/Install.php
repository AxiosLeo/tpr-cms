<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 17:21
 */
namespace app\admin\controller;

use think\Controller;

class Install extends Controller{
    public function index(){
        $lock_file = APP_PATH."../install.lock";
//        dump($lock_file);
        if(file_exists($lock_file)){
            echo "install.lock exits";die();
        }

        $system = [
            "operating system"=>PHP_OS,
            "php version"=>PHP_VERSION,
            "disk space"=> floor(disk_free_space(APP_PATH) / (1024*1024)).'M'
        ];
        $this->assign('system',$system);

        $dir = [
            '/runtime'=>is_writable(APP_PATH."../runtime")?true:false
        ];
        $this->assign('dir',$dir);

        $module = [
            "pdo"=>class_exists('pdo'),
            "redis"=>class_exists('redis'),
        ];
        $this->assign('module',$module);
        return $this->fetch('index');
    }

    public function database(){
        return $this->fetch('database');
    }
}