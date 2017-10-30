<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/18
 * Time: 19:13
 */

namespace app\admin\model;


class User extends Base
{
    //自动设置md5加密
    protected function setPwdAttr($val){
        return md5($val);
    }
}