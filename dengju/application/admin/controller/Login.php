<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Login extends Controller{

public function index(){
    return view();
}
    public function upup(){
        $username=input('post.username');
        $password=input('post.password');

        if($username){
            if($password){
                $arr=[
                    "username"=>$username,
                    "password"=>$password,
                    "status"=>1,
                ];
                $data=Db::table('admin')->where($arr)->find();

                if($data){
                    session("lock_username",$data["username"]);
                    session("lock_id",$data["id"]);
                    $this->success("登录成功","index/index","","2");
                }else{
                    $this->error("登录失败");
                }
            }else{
                $this->error("请输入密码");
            }
        }else{
            $this->error("请输入账号");
        }
    }
    public function destory(){
        session(null);
        $this->redirect("login/index");
    }

}