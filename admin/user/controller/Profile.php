<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 13:38
 */
namespace admin\user\controller;

use admin\common\controller\HomeLogin;
use axios\tpr\core\Result;
use axios\tpr\service\ToolService;
use think\Db;
use think\Session;

class Profile extends HomeLogin {
    public function update(){
        if($this->request->isPost()){
            $this->error('aaa','',$this->param);
        }
        $this->error("error");
    }

    public function avatar(){
        $file = $this->request->file('avatar');
        $save_name = ToolService::uuid();

        if(empty($file)){
            Result::wrong(500,"上传失败");
        }
        $file->setSaveName($save_name);
        $info = $file->move(ROOT_PATH."/public/uploads/images/");

        if(!empty($info)){
            $pathname = $info->getPathname();
            $pathname = substr($pathname,strpos($pathname,"uploads"));
            $user = user_info();
//            $data = [
//                'file_ext'=>$info->getExtension(),
//                'save_name'=>$info->getSaveName(),
//                'file_name'=>$info->getFilename(),
//                'file_path'=>$info->getPath(),
//                'file_pathname'=>$pathname,
//                'user'=>$user
//            ];
            $user['avatar'] = '/'.$pathname;
//            Db::name('admin')->where('id',$user['id'])->update($user);
//            Session::set('user',$user);
            Result::rep($user['avatar']);
//            $this->success($pathname);
        }else{
            Result::wrong(500,$file->getError());
//            $this->error($file->getError());
        }
    }
}