<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/17
 * Time: 8:39
 */

namespace app\admin\controller;
use app\admin\model\Category;
use app\admin\model\Tag;
use think\Db;
use think\Image;
use think\Request;
use app\admin\model\Article;
class Content extends Base
{
    public function index(){
        $res = Db::table('article')
            ->field('article.id,author,keywords,category.cat_name,title')
            ->alias('a')
            ->join('category c','a.cateid=c.id','left')
            ->paginate(5);
        $page = $res->render();
        $this -> assign('page',$page);
        $this -> assign('content',$res);
        return $this -> fetch();
    }
    public function add(){
        $cat = new Category();
        $res = $cat -> all();
        $this -> assign('list',$res);

        $tag = new Tag();
        $tag_list = $tag -> all();
        $this -> assign('tag_list',$tag_list);

        return $this -> fetch();
    }
    public function addHandle(){
        $data = Request::instance()->param();
        if($_FILES['pic']['error'] == 0){
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if($info){
                $filename = $info->getSaveName();;
                $image = Image::open('./upload/'.$filename);
                if(!file_exists('./thumb/'.date('Ymd'))){
                    mkdir('./thumb/'.date('Ymd'),0777,true);
                }
                $image->thumb(230, 200)->save('./thumb/'.$filename);
                $data['pic'] = $filename;
            }
        }
        isset($data['state'])?$data['state']=1:$data['state']=0;
        $content = new Article();
        $res = $content -> allowField(true) -> data($data) -> save();
        if($res){
            $this -> success("添加成功","/admin/content/index");
        }else{
            $this -> error("添加失败","/admin/content/add");
        }
    }

    public function edit(){
        $id = input('get.id');
        //查询文章
        $res = Article::get($id);
        $res = $res -> toArray();
        $this -> assign('content',$res);
        //查询标题
        $cat = Category::all();
        $this ->assign('cat',$cat);
        //查询标签
        $tag = new Tag();
        $tag_list = $tag -> all();
        $this -> assign('tag_list',$tag_list);

        return $this -> fetch();
    }
    public function update(){
        $id = input('post.id');
        $data = Request::instance()->param();
        if($_FILES['pic']['error'] == 0){
            $pic = Article::where('id','eq',$id)->field('pic')->find();
            $thumb = $pic->toArray();
            unlink('./thumb/'.$thumb['pic']);
            unlink('./upload/'.$thumb['pic']);
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if($info){
                $filename = $info->getSaveName();;
                $image = Image::open('./upload/'.$filename);
                if(!file_exists('./thumb/'.date('Ymd'))){
                    mkdir('./thumb/'.date('Ymd'),0777,true);
                }
                $image->thumb(230, 200)->save('./thumb/'.$filename);
                $data['pic'] = $filename;
            }
        }
        isset($data['state']) ? $data['state']=1 : $data['state']=0;
        $content = new Article();
        $res = $content -> save($data,$id);
        //$res = Article::where('id','eq',$id)->update($data);
        //$res = $content ->allowField(true) -> data($data) -> update($data,$id);
        if($res){
            $this -> success("修改成功","/admin/content/index");
        }else{
            $this -> error("修改失败","/admin/content/index");
        }
    }

    public function delete(){
        $id = input('get.id');
        $pic = Article::where('id','eq',$id)->field('pic')->find();
        $thumb = $pic->toArray();
        unlink('./thumb/'.$thumb['pic']);
        unlink('./upload/'.$thumb['pic']);

        $content = new Article();
        $res = $content -> where('id','eq',$id) -> delete();
        if($res){
            $this -> success("删除成功","/admin/content/index");
        }else{
            $this -> error("删除失败","/admin/content/index");
        }
    }

}