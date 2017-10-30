<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/18
 * Time: 23:20
 */

namespace app\admin\controller;


use app\admin\model\User;
use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function login(){
        return $this -> fetch();
    }
    public function doLogin(){
        $data = Request::instance()->param();
        if(!captcha_check($data['captcha'])){
            $this -> error('验证码错误','/admin/login/login');
        }

        $user = new User();
        $res = $user
            -> where('username','eq',$data['username'])
            -> where('pwd','eq',md5($data['pwd']))
            -> find();
        if($res){
            Session::set('username',$data['username']);
            $this -> success("登陆成功","/admin/index/index");
        }else{
            $this -> error("用户名或密码错误","/admin/login/login");
        }
    }

    public function outLogin(){
        Session::delete('username');
        $this -> success('退出成功',"/admin/login/login");
    }

}