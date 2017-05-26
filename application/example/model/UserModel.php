<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:45
 */
namespace app\example\model;

use think\Model;

class UserModel extends Model{
    protected $name = "users";

    public static function self(){
        return new self();
    }
    public function exits($username){
        return $this->where('login_name',$username)->count();
    }

    public function findUser($user_id=0,$username='',$field = ''){
        if($user_id){
            $this->where('id',$user_id);
        }

        if(!empty($username)){
            $this->where('login_name',$username);
        }
        if(!empty($field)){
            $this->field($field);
        }

        return $this->find()->getData();
    }

    public function addUser($data){
        return $this->insertGetId($data);
    }

    public function updateUser($data,$user_id=0){
        if($user_id){
            return $this->where('id',$user_id)->update($data);
        }
        return false;
    }
}