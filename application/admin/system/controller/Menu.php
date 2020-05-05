<?php

declare(strict_types=1);

namespace admin\system\controller;

use admin\common\controller\AdminLogin;

class Menu extends AdminLogin
{
    public function index()
    {
        return $this->fetch();
    }
}
