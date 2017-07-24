<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:10
 */

namespace api\common\controller;

use think\Controller;
use think\Request;

/**
 * Class ApiLogin
 * @package api\common\controller
 * @function string commonFilter adf
 * @function string commonFilter
 */
class ApiLogin extends Controller
{
    protected $user;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }
}