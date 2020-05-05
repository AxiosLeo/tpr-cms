<?php

declare(strict_types=1);

namespace admin\common\controller;

use admin\common\models\Menu;

class AdminLogin extends AdminBase
{
    public function __construct()
    {
        parent::__construct();
        $MenuModel = new Menu();
        if (empty($MenuModel->findAll())) {
            $MenuModel->init();
        }
        $this->assign('menu', $MenuModel->getMenu());
    }
}
