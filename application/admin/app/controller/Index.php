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
use think\Tool;
use tpr\admin\app\validate\Application;
use tpr\admin\common\controller\AdminLogin;

class Index extends AdminLogin{
    /**
     * 应用列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
                $r['last_version_time'] = trans2time($r['last_version_time']);
            }
            unset($r);
            $count = Db::name('app')->where($where)->count();

            $this->tableData($list , $count);
        }
        return $this->fetch();
    }

    /**
     * 编辑应用信息
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit(){
        $id = $this->param['id'];

        if($this->request->isPost()){

            $update = [
                'app_name'=>$this->param['app_name']
            ];

            $result = Db::name('app')->where('id',$id)->update($update);

            $result ? $this->success(lang('success')) : $this->error(lang('error'));
        }

        $data = Db::name('app')->where('id',$id)->find();
        $this->assign('data',$data);

        return $this->fetch();
    }

    /**
     * 查看应用详细信息
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function view()
    {
        $id = $this->param['id'];

        $app = Db::name('app')->where('id', $id)->find();
        if (!empty($app)) {
            $app['last_version_time'] = trans2time($app['last_version_time']);
            $app['created_at'] = trans2time($app['created_at']);
        }

        $this->assign('data', $app);

        return $this->fetch();
    }

    /**
     * 创建应用
     * @return mixed
     */
    public function create()
    {
        if ($this->request->isPost()) {

            $Validate = new Application();
            if (!$Validate->scene('software.add')->check($this->param)) {
                $this->error($Validate->getError());
            }

            $insert = [
                'platform' => $this->param['platform'],
                'app_name' => $this->param['app_name'],
                'base_version' => $this->param['base_version'],
                'remark' => $this->param['remark'],
                'app_status' => 1,
                'created_at' => time(),
                'app_id'   => Tool::uuid("app_id"),
                'app_secret'=>Tool::uuid("app_secret")
            ];

            if (Db::name('app')->insertGetId($insert)) {
                $this->success('Operation is successful');
            } else {
                $this->error('The operation failure');
            }
        }

        return $this->fetch();
    }
}