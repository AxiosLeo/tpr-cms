<?php

declare(strict_types = 1);

namespace admin\index\controller;

use admin\common\controller\AdminLogin;

class Index extends AdminLogin
{
    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
        return $this->fetch();
    }
}
