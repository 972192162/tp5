<?php
/**
 * Created by PhpStorm.
 * Users: 董辉
 * Date: 2017/10/18
 * Time: 19:11
 */

namespace app\admin\controller;
use app\admin\model\User;
use app\admin\validate\UserRule;
use think\Request;
use think\Session;

class Users extends Base
{

    public function index()
    {
       $res = User::paginate(5);
       $this -> assign('user',$res);
       return $this -> fetch();
    }
    public function add(){
        return $this -> fetch();
    }
    public function addHandle(){
          $data = Request::instance()->param();
          $validate = new UserRule();
          $res = $validate->batch()->check($data);
          if(!$res){
            $error=$validate->getError();
            if(!isset($error['username'])){
                $this ->error($error['pwd'],'/admin/users/add');
            }elseif(!isset($error['pwd'])){
                $this ->error($error['username'],'/admin/users/add');
            }else{
                $this ->error($error['username'].$error['pwd'],'/admin/users/add');
            }
          }
          $user = new User();
          $data['pwd'] = md5($data['pwd']);
          $res = $user -> data($data) -> save();
          if($res){
               $this -> success("添加成功","/admin/users/index");
          }else{
               $this -> error("添加失败","/admin/users/add");
          }
    }
    public function edit(){
        $id = input('get.id');
        $user = new User();
        $list = $user -> get($id) -> field('username')->find();
        $this -> assign('user',$list);
        $this -> assign('id',$id);
        return $this -> fetch();
    }
    public function update(){
        $data = Request::instance()->param();
        $validate = new UserRule();
        $res = $validate->batch()->check($data);
        if(!$res){
            $error=$validate->getError();
            if(!isset($error['username'])){
                $this ->error($error['pwd'],'/admin/users/index');
            }elseif(!isset($error['pwd'])){
                $this ->error($error['username'],'/admin/users/index');
            }else{
                $this ->error($error['username'].$error['pwd'],'/admin/users/index');
            }
        }
        $user = new User();
        $res = $user ->  save($data,$data['id']);
        if($res){
            $this -> success("修改成功","/admin/users/index");
        }else{
            $this -> error("修改失败","/admin/users/index");
        }
    }
    public function delete(){
        $id = input('get.id');
        $user =new User();
        $res = $user -> where('id','eq',$id) -> delete();
        if($res){
            $this -> success("删除成功","/admin/users/index");
        }else{
            $this -> error("删除失败","/admin/users/index");
        }
    }


}