<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/18
 * Time: 19:30
 */

namespace app\admin\validate;

use think\Validate;

class UserRule extends Validate
{
    protected $rule = [
        'username'  =>  'require|userRule',
        'pwd'       =>  'require|pwdRule',
    ];
    protected $message = [
        'username'  =>  '用户名字母开头，5-10位数字',
        'pwd'       =>  '密码任意字符，5-30位',
    ];
    protected function userRule($val){
        $rule = '/[a-zA-Z]\w{4,9}/';
        if(preg_match($rule,$val)){
            return true;
        }else{
            return false;
        }
    }
    protected function pwdRule($val){
        $rule = '/[\w?!@#$%^&*()_+~`|}{\[\]:;\"\'.,?\/]{4,29}/';
        if(preg_match($rule,$val)){
            return true;
        }else{
            return false;
        }
    }
}