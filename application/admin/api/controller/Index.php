<?php

declare(strict_types=1);

namespace admin\api\controller;

use tpr\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'API manage page';
    }
}
