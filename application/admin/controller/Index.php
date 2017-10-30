<?php
namespace app\admin\controller;


class Index extends Base
{
    public function index()
    {
        $c_model = model('category');
        $res = $c_model ->paginate(5);
        $page = $res->render();
        $this -> assign('list',$res);
        $this -> assign('page',$page);
        return $this -> fetch();
    }
    public function add(){
        return $this -> fetch();
    }
    public function addHandle(){
        $catname = input('post.category');
        $c_model = model('category');
        $res  = $c_model -> create(["cat_name"=>$catname]);
        if($res){
            $this -> success("添加成功","/admin/index/index");
        }else{
            $this -> error("添加失败","/admin/index/add");
        }
    }
    public function edit(){
        $id = input("get.id");
        $c_model = model('category');
        $res = $c_model -> get($id);
        $this ->assign("id",$id);
        $this -> assign("cat_name",$res['cat_name']);
        return $this -> fetch();
    }
    public function update(){
        $id = input('post.id');
        $cat_name = input('post.category');
        $c_model = model('category');
        $res = $c_model -> update(["cat_name"=>$cat_name],['id'=>$id]);
        if($res){
            $this -> success("修改成功","/admin/index/index");
        }else{
            $this -> error("修改失败","/amdin/index/index");
        }
    }
    public function delete(){
        $id = input('get.id');
        $c_model = model('category');
        $res = $c_model -> destroy($id);
        if($res){
            $this -> success("删除成功","/admin/index/index");
        }else{
            $this -> error("删除失败","/amdin/index/index");
        }
    }
}
