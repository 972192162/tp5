<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/19
 * Time: 15:41
 */

namespace app\index\model;


use think\Model;

class Article extends Model
{
    //一对一链表查询
    public function Tag(){
        //参数1 关联表名
        //参数2 关联表的关联字段
        //参数3 本表的主键
        return $this -> hasOne('Tag','id','id');
    }

}