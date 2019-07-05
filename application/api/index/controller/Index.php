<?php

namespace App\api\index\controller;

use App\api\index\common\ApiBaseController;

class Index extends ApiBaseController
{
    public function index()
    {
        return "hello, world! this is api application";
    }
}