<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */

namespace tpr\api\index\controller;

use library\controller\ApiBase;
use think\Db;
use think\Doc;

/**
 * Class Index
 * @package api\index\controller
 */
class Index extends ApiBase
{
    /**
     * hello world
     * @desc example
     * @method get
     */
    public function index()
    {
        $this->response(["hello world!"]);
    }

    /**
     * send $name
     * @desc example
     * @parameter string name 名称
     * @method post|get
     */
    public function needName()
    {
        $this->response(["name" => $this->param['name']]);
    }

    /**
     * example for cache
     * @desc example
     * @method get
     */
    public function cache()
    {
        sleep(3);
        $this->response(['hello' => "world", "timestamp" => time()]);
    }

    /**
     * get doc
     * @desc example
     * @method get
     */
    public function apiDoc()
    {
        $config = [
            'doc_path' => Doc::getClassPathList(),
            'load_path' => [ROOT_PATH . 'library', APP_PATH],
            'app_namespace' => 'tpr\api'
        ];
        $this->response(Doc::set($config)->doc());
    }

    public function name()
    {
        $name = $this->request->param('name', 'name is empty');

        $this->response(['name' => $name]);
    }

    public function model()
    {
        $start = memory_get_usage();
        dump('start:' . $start . 'byte');

        Db::model('app');
        dump(memory_get_usage() . 'byte');
        Db::model('admin');
        dump(memory_get_usage() . 'byte');
        Db::model('menu','mongo.default');
        dump(memory_get_usage() . 'byte');

        $end = memory_get_usage();
        dump('end:' . $end . 'byte');

        dump('差值: ' . floor(($end - $start) / 1024) . 'KB');

        echo "<br>------------------------------------<br>";

        $start = memory_get_usage();
        dump('start:' . $start . 'byte');

        db('app');
        dump(memory_get_usage() . 'byte');
        db('admin');
        dump(memory_get_usage() . 'byte');
        db('menu');
        dump(memory_get_usage() . 'byte');

        $end = memory_get_usage();
        dump('end:' . $end . 'byte');

        dump('差值: ' . floor(($end - $start) / 1024) . 'KB');
    }


}