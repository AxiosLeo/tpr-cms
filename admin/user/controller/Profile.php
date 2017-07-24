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
use admin\user\service\AdminService;
use think\Db;
use think\Tool;

class Profile extends HomeLogin
{
    public function update()
    {
        if ($this->request->isPost()) {
            $Validate = new \admin\user\validate\Admin();
            if (!$Validate->scene('profile')->check($this->param)) {
                $this->error($Validate->getError());
            }
            $this->param['update_at'] = time();
            $result = Db::name('admin')->where('id', $this->user['id'])->update($this->param);
            if ($result) {
                $this->user = AdminService::getSessionInfo($this->user['id']);
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        }
        $this->error("error");
    }

    public function avatar()
    {
        $file = $this->request->file('avatar');
        $save_name = Tool::uuid();

        if (empty($file)) {
            $this->wrong(500, "上传失败");
        }
        $file->setSaveName($save_name);
        $info = $file->move(ROOT_PATH . "/public/uploads/images/");

        if (!empty($info)) {
            $pathname = $info->getPathname();
            $pathname = substr($pathname, strpos($pathname, "uploads"));
            $user = user_info();
            $user['avatar'] = '/' . $pathname;
            $this->response($user['avatar']);
        } else {
            $this->wrong(500, $file->getError());
        }
    }
}