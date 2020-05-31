<?php

declare(strict_types=1);

namespace admin\user\controller;

use admin\common\controller\AdminBase;
use admin\common\User;
use function cms\createUrl;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Index extends AdminBase
{
    public function login()
    {
        if ($this->request->isPost()) {
            if (empty($this->request->post('username'))) {
                $this->error('请输入用户名', 400);
            }
            if (empty($this->request->post('password'))) {
                $this->error('请输入密码', 400);
            }
            if (empty($this->request->post('verify'))) {
                $this->error('请输入验证码', 400);
            }
            $verify = $this->request->post('verify');
            $phrase = $this->session->read('phrase');
            if (empty($phrase)) {
                $this->response('验证码错误(' . $phrase . ')', 400);
            }
            $result = PhraseBuilder::comparePhrases($phrase, $verify);
            if ($result) {
                $user = new User();
                $user->refreshInfo(['avatar' => '/src/images/user.jpg']);
                $this->success([], createUrl('index', 'index', 'index'));
            } else {
                $this->error('验证码错误' . $phrase . ':' . $verify, 400);
            }
        }
        $user = new User();
        if ($user->isLogin()) {
            $this->redirect(createUrl('index', 'index', 'index'));
        }

        return $this->fetch();
    }

    public function captcha()
    {
        $this->setHeaders('Content-type', 'image/jpeg');
        $captcha = new CaptchaBuilder();
        $phrase  = $captcha->getPhrase();
        $this->session->write('phrase', $phrase);
        $this->session->save();
        $captcha->build()->output();
    }
}
