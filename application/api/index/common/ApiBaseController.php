<?php

namespace App\api\index\common;

use tpr\Controller;

class ApiBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setResponseType("json");
    }
}