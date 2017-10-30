<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/18
 * Time: 14:41
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

class Base extends Controller
{
    protected $beforeActionList = [
        'checkUser'
        //'checkUser' => ['except'=>'doLogin'],
    ];
    public function checkUser(){

        if(!Session::has('username')){
            $this -> error('请先登陆',"/admin/login/login");
        }
    }
    //上传
    public function upload($name){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($name);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            return  $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo   $info->getFilename();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
}