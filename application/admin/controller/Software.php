<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 17:14
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\ToolService;
use think\Db;
use think\Request;
class Software extends HomeLogin{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-apple');
    }
    public function index(){
        $this->assign('list',Db::name('app')->select());
        return $this->fetch('index');
    }

    public function add(){
        if($this->request->isPost()){
            $insert = [
                'app_name'=>$this->param['app_name'],
                'platform'=>$this->param['platform'],
                'base_version'=>$this->param['base_version'],
                'remark'=>$this->param['remark'],
                'app_status'=>1,
                'created_at'=>time()
            ];
            $insert['app_id'] = ToolService::token("app_id");
            $insert['app_secret'] = ToolService::token("app_secret");
            if(Db::name('app')->insertGetId($insert)){
                $this->success("操作成功",url('admin/software/index'));
            }else{
                $this->error("操作失败");
            }
        }

        return $this->fetch('add');
    }

    public function edit(){
        $id = $this->param['id'];

        if($this->request->isPost()){
            $update = [
                'app_name'=>$this->param['app_name'],
                'platform'=>$this->param['platform'],
                'remark'=>$this->param['remark'],
                'update_at'=>time()
            ];
            if(Db::name('app')->where('id',$id)->update($update)){
                $this->success("操作成功",url('admin/software/index'));
            }else{
                $this->error("操作失败");
            }
        }

        $data = Db::name('app')->where('id',$id)->find();
        return $this->fetch('edit',['data'=>$data]);
    }

    public function turn(){
        $id = $this->param['id'];
        $turn = $this->param['turn'];

        if(Db::name('app')->where('id',$id)->setField('app_status',$turn)){
            $this->success("操作成功" ,url('admin/software/index'));
        }else{
            $this->error("操作失败" );
        }
    }
}