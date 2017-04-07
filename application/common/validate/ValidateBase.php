<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 11:37
 */
namespace app\common\validate;

use app\common\service\LangService;
use think\Validate;

class ValidateBase extends Validate{
    function __construct(array $rules = [], array $message = [], array $field = [])
    {
        parent::__construct($rules, $message, $field);
    }

    public function getError(){
        return LangService::trans($this->error);
    }
}