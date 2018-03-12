<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/20 上午10:00
 */

namespace tpr\admin\app\controller;

use think\Db;
use think\Tool;
use tpr\admin\app\validate\Application;
use tpr\admin\common\controller\AdminLogin;

class Version extends AdminLogin
{
    /**
     * 版本列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        if($this->request->isPost()){
            $page = $this->param['page'];
            $limit = $this->param['limit'];
            $keyword = $this->request->param('keyword' , '');
            $app_id = $this->request->param('app_id',0);
            $where = [];
            $query = Db::name('app_version')->alias('v')
                ->join('__APP__ app' ,'app.app_id=v.app_id')
                ->field('v.id , app.app_name , v.app_version , v.app_key ,v.publish_time ,v.version_type,v.app_build,v.app_status')
                ->order('publish_time desc')
                ->page($page)
                ->limit($limit);

            if(!empty($keyword)){
                if(strlen($keyword) === 32){
                    $query = $query->where('v.app_key',$keyword);
                }else{
                    if(strpos($keyword ,'-')!==false){
                        list($version , $build) = explode('-',$keyword);
                        $query = $query->where('v.app_version',$version)
                            ->where('v.app_build',$build);
                    }else{
                        $query = $query->whereOr('v.app_version',$keyword)
                            ->whereOr('v.app_build',$keyword);
                    }
                }
            }
            if(!empty($app_id)){
                $where['v.app_id'] = $app_id;
                $query = $query->where('v.app_id',$app_id);
            }
            $list = $query->select();

            foreach ($list as &$l){
                $l['publish_time'] = trans2time($l['publish_time']);
            }

            $count = Db::name('app_version')->alias('v')->where($where)->count();
            $this->tableData($list , $count);
        }

        $app = Db::name('app')->select();

        $this->assign('app',$app);

        return $this->fetch();
    }

    /**
     * 发布时间线
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function timeLine(){
        $list = Db::name('app_version')->alias('v')
            ->join('__APP__ app' ,'app.app_id=v.app_id')
            ->field('v.id , app.app_name , v.app_version , v.app_key ,v.publish_time ,v.version_type,v.app_build,v.app_status,v.remark')
            ->order('publish_time desc')
            ->select();

        $this->assign('version',$list);

        return $this->fetch('time_line');
    }

    /**
     * 发布新版本
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function publish()
    {
        if ($this->request->isPost()) {
            $Validate = new Application();

            if (!$Validate->scene('version.add')->check($this->param)) {
                $this->error($Validate->getError());
            }

            $app_version = !empty($this->param['app_build'])?$this->param['app_version'] . '.' . $this->param['app_build']:$this->param['app_version'];

            $insert = [
                'app_id'       => $this->param['app_id'],
                'app_version'  => $this->param['app_version'],
                'app_build'    => $this->param['app_build'],
                'app_key'      => $this->param['app_key'],
                'version_type' => $this->param['version_type'],
                'update_type'  => $this->param['update_type'],
                'app_status'   => 1,
                'publish_time' => date("Y-m-d H:i:s")
            ];

            if (Db::name('app_version')->insertGetId($insert)) {
                $app['last_version'] = $app_version;
                $app['last_version_time'] = time();
                Db::name('app')->where('app_id', $this->param['app_id'])->update($app);

                $this->success('success');
            }

            $this->error('error');
        }

        $id = $this->request->param('id' , '');
        $this->assign('app_id',$id);
        $apps = Db::name('app')->field('app_id , app_name, id')->select();

        $this->assign('apps',$apps);

        if(empty($id)){
            $version['version'] = "请选择";
            $version['build'] = '请选择';
            $this->assign('app_key', Tool::uuid('app_key'));
        }else{
            $app = Db::name('app')->find($id);
            $this->assign('app', $app);
            $this->assign('app_key', Tool::uuid('app_key'));

            if (!empty($app) && isset($app)) {
                $version = $this->makeAppVersion($app, 0);
            } else {
                $version['version'] = "请选择";
                $version['build'] = '请选择';
            }
        }


        $this->assign('version', $version);

        return $this->fetch('publish');
    }

    /**
     * 获取版本号
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getVersion()
    {
        $app_id = $this->param['app_id'];
        $version_type = $this->param['version_type'];
        $update_type = $this->param['update_type'];

        $app = Db::name('app')->where('app_id', $app_id)->find();
        if (empty($app)) {
            $app = ['version'=>'请选择', 'build'=>'请选择'];
            $this->response($app);
        }

        $version = $this->makeAppVersion($app, $update_type, $version_type);

        $count = Db::name('app_version')->where('app_id',$app_id)
            ->where('app_build',$version['build'])->count();
        if($count){
            $version['build'] = $version['build'] . '_' . (++$count);
        }

        $this->response($version);
    }

    /**
     * 版本描述(未启用)
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function remark(){
        $id = $this->request->param('id',0);

        if($this->request->isPost()){
            $remark = $this->request->param('remark','');
            $remark = htmlspecialchars($remark);

            Db::name('app_version')
                ->where('id',$id)
                ->setField('remark',$remark);

            $this->success(lang('success'));
        }

        $this->assign('id',$id);
        $version = Db::name('app_version')
            ->where('id',$id)
            ->field('id,remark')
            ->find();

        $this->assign('remark',htmlspecialchars_decode($version['remark']));

        return $this->fetch();
    }


    /**
     * @param $app
     * @param $update_type
     * @param string $version_type
     * @return array
     */
    private function makeAppVersion($app, $update_type, $version_type = "release")
    {
        $temp_base = $app['base_version'];

        if (!empty($app['last_version'])) {
            list($temp_main, $temp_next, $temp_debug) = explode(".", $app['last_version']);
        } else {
            $temp_main = $temp_base;
            $temp_next = 0;
            $temp_debug = 0;
        }
        $main = $temp_main;
        $next = 0;
        $debug = 0;
        switch ($update_type) {
            case 2:
                $main = ++$app['base_version'];
                break;
            case 1:
                $next = ++$temp_next;
                break;
            case 0:
                $next = $temp_next;
                $debug = ++$temp_debug;
                break;
        }

        return $this->makeVersion($main, $next, $debug, $version_type);
    }

    /**
     * @param $main
     * @param string $next
     * @param string $debug
     * @param string $type
     * @return array
     */
    private function makeVersion($main, $next = "0", $debug = "0", $type = "release")
    {
        $app = [
            'version' => $main . "." . $next . "." . $debug,
            'build' => date("ymd") . "_" . $type
        ];
        return $app;
    }
}