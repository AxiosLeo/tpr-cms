<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/19 下午1:48
 */
namespace tpr\admin\app\controller;

use think\Db;
use tpr\admin\common\controller\AdminLogin;

class Index extends AdminLogin{
    /**
     * 应用列表
     * @return mixed
     */
    public function index()
    {

        if($this->request->isPost()){
            $page = $this->request->param('page',1);
            $limit = $this->request->param('limit',10);
            $keyword = $this->request->param('keyword','');
            $where = [];
            if(!empty($keyword)){
                $keyword = '%' . $keyword . '%';
                $where['app_name'] = ['like',$keyword];
            }
            $list = Db::name('app')->page($page)->where($where)->limit($limit)->select();
            foreach($list as &$r){
                $r['last_version_time'] = !empty($r['last_version_time'])?date('Y-m-d H:i:s',$r['last_version_time']):'';
            }
            unset($r);
            $count = Db::name('app')->where($where)->count();

            $this->tableData($list , $count);
        }
        return $this->fetch();
    }

    /**
     * 查看应用详细信息
     * @return mixed
     */
    public function view()
    {
        $id = $this->param['id'];

        $app = Db::name('app')->where('id', $id)->find();
        if (!empty($app)) {
            $app['last_version_time'] = date("Y-m-d H:i:s", $app['last_version_time']);
            $app['created_at'] = date("Y-m-d H:i:s", $app['created_at']);
        }

        $this->assign('data', $app);

        return $this->fetch();
    }
}