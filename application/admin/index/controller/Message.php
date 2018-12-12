<?php
/**
 * @author  : axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/9/5 上午10:46
 */

namespace tpr\admin\index\controller;

use library\controller\BaseController;

class Message extends BaseController
{
    /**
     * @except
     */
    public function none()
    {
        $this->wrong(401, '无授权');
    }

    public function captcha()
    {
        $captcha_image_content = captcha_create();
        $this->output($captcha_image_content, ['Content-type' => 'image/jpeg']);
    }
}