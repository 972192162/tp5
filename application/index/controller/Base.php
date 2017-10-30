<?php
/**
 * Created by PhpStorm.
 * User: 董辉
 * Date: 2017/10/19
 * Time: 14:45
 */

namespace app\index\controller;
use app\admin\model\Category;
use app\admin\model\Tag;
use app\index\model\Article;
use think\Db;

use think\Controller;

class Base extends Controller
{
    public function index(){
        $cat = Category::field("cat_name")->paginate(9);
        $this -> assign('cat',$cat);

        $tag = Tag::field("tag_name")->paginate(9);
        $this -> assign('tag',$tag);

        $content = Db::table('article')
            ->field('a.*,t.id as t_id,t.tag_name')
            ->alias('a')
            ->join('tag t','a.tagid=t.id','left')
            ->paginate(9);
        $this -> assign('content',$content);

        $tujian = Article::where('state','eq','1')
            ->field('title,id')
            ->limit(0,4)
            ->select();
        $this ->assign('tujian',$tujian);

        $hot = Article::field('title,id')
            ->order('click','desc')
            ->limit(0,4)
            ->select();
        $this ->assign('hot',$hot);
    }
}