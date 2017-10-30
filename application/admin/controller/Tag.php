<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/16
 * Time: 21:09
 */

namespace app\admin\controller;




class Tag extends Base
{
    public function index()
    {
        $t_model = model('tag');
        $res = $t_model -> paginate(5);
        $page = $res->render();
        $this -> assign('page',$page);
        $this -> assign('list',$res);
        return $this -> fetch();
    }
    public function add(){
        return $this -> fetch();
    }
    public function addHandle(){
        $tagname = input('post.tag');
        $t_model = model('tag');
        $res  = $t_model -> create(["tag_name"=>$tagname]);
        if($res){
            $this -> success("添加成功","/admin/tag/index");
        }else{
            $this -> error("添加失败","/admin/tag/add");
        }
    }
    public function edit(){
        $id = input("get.id");
        $t_model = model('tag');
        $res = $t_model -> get($id);
        $this ->assign("id",$id);
        $this -> assign("tag_name",$res['tag_name']);
        return $this -> fetch();
    }
    public function update(){
        $id = input('post.id');
        $tag_name = input('post.tag');
        $t_model = model('tag');
        $res = $t_model -> update(["tag_name"=>$tag_name],['id'=>$id]);
        if($res){
            $this -> success("修改成功","/admin/tag/index");
        }else{
            $this -> error("修改失败","/amdin/tag/index");
        }
    }
    public function delete(){
        $id = input('get.id');
        $t_model = model('tag');
        $res = $t_model -> destroy($id);
        if($res){
            $this -> success("删除成功","/admin/tag/index");
        }else{
            $this -> error("删除失败","/amdin/tag/index");
        }
    }
}