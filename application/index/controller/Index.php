<?php
namespace app\index\controller;


use app\admin\model\Article;
use app\admin\model\Category;
use app\admin\model\Tag;
use think\Db;
use think\Log;

class Index extends Base
{
    public function index(){

        parent::index();

        return $this -> fetch();
    }

    public function tagList()
    {
        parent::index();
        $tag = input('get.tag');
        $tagList = Db::table('article')
            ->where('tag_name','eq',$tag)
            ->field('a.*,t.id as t_id,t.tag_name')
            ->alias('a')
            ->join('tag t','a.tagid=t.id','left')
            ->paginate(9);
        $this -> assign('tagList',$tagList);
        return $this -> fetch();
    }
    public function keyWord(){
        $keyword = input('get.keyword');
        $keyword = Article::where('keywordS',"like","%".$keyword."%")
            ->field('keywordS')
            ->select();
        echo json_encode($keyword);
    }

}
