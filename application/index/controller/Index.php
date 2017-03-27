<?php
namespace app\index\controller;

use app\common\controller\ApiBase;
use think\Request;
use think\Route;
class Index extends ApiBase
{
    public function index()
    {
        $this->res("success");
    }
}
