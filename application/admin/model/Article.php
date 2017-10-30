<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/17
 * Time: 8:41
 */

namespace app\admin\model;


class Article extends Base
{
    protected $autoWriteTimestamp = true;
    //指定自动完成那些字段
    protected $auto = [];
    protected $insert = ['time','create_time','update_time'];
    protected $update = ['update_time'];

    //自动添加图片路径
//    protected function getPicAttr($val){
//        return config('img_url').$val;
//    }
    //自动设置md5加密
    protected function setPasswordAttr($val){
        return md5($val);
    }
    protected function setCreateTimeAttr(){
        return time();
    }
    protected function setUpdateTimeAttr(){
        return time();
    }

    //设置自动完成
    protected function setTimeAttr(){
        return time();
    }
}