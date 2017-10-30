<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/19
 * Time: 14:29
 */

namespace app\admin\controller;


use think\Controller;

class Error extends Controller
{
    public function _empty(){
        $this -> redirect("/admin/login/login");
    }
}