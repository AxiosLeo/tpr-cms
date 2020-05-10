<?php

declare(strict_types=1);

namespace admin\common\controller;

use admin\common\models\Menu;
use admin\common\User;
use function cms\createUrl;

class AdminLogin extends AdminBase
{
    /**
     * @var User
     */
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        if (!$this->user->isLogin()) {
            $this->redirect(createUrl('user', 'index', 'login'));
        }
        $MenuModel = new Menu();
        if (empty($MenuModel->findAll())) {
            $MenuModel->init();
        }
        $this->assign('menu', $MenuModel->getMenu());
        $this->assign('user_info', $this->user->getInfo());
    }
}
