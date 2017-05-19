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

class Profile extends HomeLogin {
    public function update(){
        $this->error("error");
    }

    public function avatar(){
        $file = $this->request->file('file');
        $save_name = ToolService::uuid();

        $file->setSaveName($save_name);
        $info = $file->move(ROOT_PATH."/public/uploads/images/");

        if(!empty($info)){
            $pathname = $info->getPathname();
            $pathname = substr($pathname,strpos($pathname,"uploads"));
            $user = user_info();
            $data = [
                'file_ext'=>$info->getExtension(),
                'save_name'=>$info->getSaveName(),
                'file_name'=>$info->getFilename(),
                'file_path'=>$info->getPath(),
                'file_pathname'=>$pathname,
                'user'=>$user
            ];
            Result::rep($data);
        }else{
            Result::rep($file->getError());
        }
    }
}