<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:08
 */
namespace admin\system\controller;

use admin\common\controller\HomeLogin;

class Setting extends HomeLogin{
    public function index(){
        if (is_file(ROOT_PATH . '.env')) {
            $env = parse_ini_file(ROOT_PATH . '.env', true);
            $this->assign('env',$env);
            return $this->fetch('index');
        }else{
            echo "没有找到.env文件<br />";
            echo "请确认".ROOT_PATH.".env文件是否存在";
        }
        return "";
    }
}