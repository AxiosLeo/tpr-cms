<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 11:37
 */
namespace app\common\validate;

use think\Validate;

class ValidateBase extends Validate{
    function __construct(array $rules = [], array $message = [], array $field = [])
    {
        parent::__construct($rules, $message, $field);
    }

    public function getError(){
        $error = explode('@', $this->error);
        $str = '';
        foreach ($error as $e){
            $tmp = lang($e);
            if($e===$tmp){
                $str.=lang($e)." ";
            }else{
                $str.=lang($e);
            }
        }
        return $str;
    }
}