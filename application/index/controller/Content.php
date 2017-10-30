<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/20
 * Time: 10:22
 */

namespace app\index\controller;


use app\index\model\Article;
use think\Cache;
use think\Db;

class Content extends Base
{
    public function content(){
        parent::index();
        $id = input('get.id');

        $info = Db::table('article')
            ->alias('a')
            ->where('a.id','eq',$id)
            ->join('tag t','a.tagid=t.id','left')
            ->find();

        Db::table('article')
            ->alias('a')
            ->where('a.id','eq',$id)
            ->setInc('click');

        $this -> assign('info',$info);
        return $this -> fetch();
    }
    public function keyword(){
        $keyword = input('get.keyword');
        $res = Article::where('keywords','like','%'.$keyword.'%')
            ->field('title')
            ->select();
        return json($res);
    }
    public function title(){
        parent::index();
        $title = input('get.q');
        $info = Db::table('article')
            ->alias('a')
            ->where('title','eq',$title)
            ->join('tag t','a.tagid=t.id','left')
            ->find();

        Db::table('article')
            ->alias('a')
            ->where('title','eq',$title)
            ->setInc('click');

        $this -> assign('info',$info);
        return $this -> fetch('content');
    }
}