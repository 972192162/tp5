<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
//当控制器名输入错误的时候会自动调用该方法
class error extends Controller
{
    //默认访问该方法
    public function index(){
        echo "你的方法名写错了";
    }
    //空方法
    public function _empty(){
        echo "都错了";
    }
}
