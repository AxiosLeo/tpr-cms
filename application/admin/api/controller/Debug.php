<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午3:00
 */

namespace tpr\admin\api\controller;

use library\logic\DocLogic;
use think\Doc;
use think\Env;
use tpr\admin\common\controller\AdminLogin;

class Debug extends AdminLogin
{
    /**
     * 接口调试页
     * @return mixed
     */
    public function index(){
        $app_namespace = $this->request->param('an','');
        $class_name = $this->request->param('cn','');
        $func_name = $this->request->param('fn','');

        $exception = ['admin'];

        DocLogic::appList(ROOT_PATH . 'application/' , $exception);
        $app_map = DocLogic::$appMap;
        $app_map = array_flip($app_map);

        if(!isset($app_map[$app_namespace])){
            echo "异常错误";
        }

        $app_path = $app_map[$app_namespace];

        DocLogic::doc($app_path);

        $method_doc = Doc::instance()->makeMethodDoc($class_name,$func_name);
        $method_comment = $method_doc['comment'];

        $path = empty($method_doc['route']) ? $method_doc['path'] : $method_doc['route'];
        $this->assign('path',$path);

        $title = data($method_comment , 'title' , '未注释');
        $this->assign('title',$title);

        $host = Env::get('web.host','http://cms.test.cn/');
        $this->assign('host', $host);

        $parameter = data($method_comment , 'parameter' , []);
        $this->assign('param',$parameter);

        return $this->fetch();
    }
}