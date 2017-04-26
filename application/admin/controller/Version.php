<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:08
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\ToolService;
use think\Db;
use think\Request;

class Version extends HomeLogin
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu', 'icon-apple');
    }

    public function index(){
        $list = Db::name('app_version')->alias('version')
            ->join('__APP__ a','a.app_id=version.app_id','left')
            ->field('version.*,a.app_name , a.platform,a.app_id')
            ->select();
        $this->assign('list',$list);
//        dump($list);die();
        return $this->fetch('index');
    }

    public function add(){
        if($this->request->isPost()){
            $insert = [
                'app_id'=>$this->param['app_id'],
                'app_version'=>$this->param['app_version'],
                'version_type'=>$this->param['version_type'],
                'update_type'=>$this->param['update_type'],
                'publish_time'=>date("Y-m-d H:i:s"),
                'app_key'=>$this->param['app_key']
            ];
            if(Db::name('app_version')->insertGetId($insert)){
                $update = [
                    'last_version'=>$this->param['app_version'],
                    'last_version_time'=>time(),
                ];
                Db::name('app')->where('app_id',$this->param['app_id'])->update($update);
                $this->success('操作成功',url('admin/version/index'));
            }else{
                $this->error('操作失败');
            }
        }

        $app = Db::name('app')->field('app_id,app_name,last_version,base_version')->select();
        $this->assign('app',$app);
        $this->assign('app_key',ToolService::token('app_key'));

        if(!empty($app) && isset($app[0])){
            $version = makeAppVersion($app[0],0);
        }else{
//            $version = makeVersion(1);
            $version = "应用不存在";
        }
        $this->assign('version',$version);
        return $this->fetch('add');
    }

    public function getVersion(){
        $app_id = $this->param['app_id'];
        $version_type = $this->param['version_type'];
        $update_type  = $this->param['update_type'];

        $app = Db::name('app')->where('app_id',$app_id)->find();
        if(empty($app)){
            $this->error("应用不存在");
        }
        $version = makeAppVersion($app,$update_type,$version_type);
        $this->success($version);
    }

    public function turn(){
        $id = $this->param['id'];

    }
}