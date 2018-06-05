<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/1 下午4:25
 */
namespace library\behavior;

use tpr\framework\Loader;

class Init {
    public function run(){
        Loader::addNamespace('library' , ROOT_PATH . 'library/');
    }
}