<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Index extends Lock
{
    public function _empty(){
        $this->redirect("admin/index/index");
    }
    public function index()
    {
        return view();
    }
    public function ajax_name()
    {
        $username=input('get.username');
        $sql=Db::table("admin")->where('username',$username)->find();
       if($sql){
           echo 1;
       }else{
           echo 0;
       }
    }
    public function adddata()
    {
        $post=input('post.');
        $username=$post['username'];
        $password=$post['password'];
        $repassword=$post['repassword'];
        $status=$post['status'];
        $time=date('Y-m-d H:i:s',time());
        if($username){
            if(strlen($username)>=6&&strlen($username)<=12){
                $sql=Db::table("admin")->where('username',$username)->find();
                if(!$sql){
                    if($password){
                        if(strlen($password)>=6&&strlen($password)<=12){
                            if($repassword===$password&&$password){
                                $data=[
                                    'username'=>$username,
                                    'time'=>$time,
                                    'password'=>$password,
                                    'status'=>$status
                                ];
                                $sql=Db::table("admin")->insert($data);
                                if($sql){
                                    $date=[
                                        "code"=>200,
                                        "info"=>"添加成功"
                                    ];
                                }else{
                                    $date=[
                                        "code"=>400,
                                        "info"=>"添加失败"
                                    ];
                                }
                            }else{
                                $date=[
                                    "code"=>400,
                                    "info"=>"两次输入密码不相等"
                                ];
                            }
                        }else{
                            $date=[
                                "code"=>400,
                                "info"=>"密码长度在6-12之间"
                            ];
                        }
                    }else{
                        $date=[
                            "code"=>400,
                            "info"=>"请输入密码"
                        ];
                    }
                }else{
                    $date=[
                        "code"=>400,
                        "info"=>"用户名已存在"
                    ];
                }
            }else{
                $date=[
                    "code"=>400,
                    "info"=>"请输入用户名在6-12字符间"
                ];
            }
        }else{
            $date=[
                "code"=>400,
                "info"=>"请输入用户名"
            ];
        }
        echo json_encode($date);

    }
    public function ajax_del(){
        $str=input("post.str");
        $data=Db::table("admin")->delete($str);
        if($data){
            $date=[
                "code"=>200,
                "info"=>"删除成功"
            ];
        }else{
            $date=[
                "code"=>400,
                "info"=>"删除失败"
            ];
        }
        echo json_encode($date);
    }
    public function ajax_bai(){
        $data=input('get.');

        $bb=Db::table("admin")->update($data);
        if ($bb){
            $date=[
                "code"=>200,
                "info"=>"修改成功"
            ];
        }else{
            $date=[
                "code"=>400,
                "info"=>"修改失败"
            ];
        }
        echo json_encode($date);
    }
    public function ajax_edit(){
        $id=$_GET['id'];
        $data=Db::table('admin')->find($id);
        $this->assign('data',$data);
        return view();
    }
    public function ajax_save(){
        $data=input("get.");
        $id=$data['id'];
        $password=$data['password'];
        $repassword=$data['repassword'];
        $status=$data['status'];
        if($password||$repassword){
            if(strlen($password)>=6&&strlen($password)<=12){
                if($password==$repassword){
                    $arr=[
                        "password"=>$password,
                        "status"=>$status
                    ];
                }else{
                    $date=[
                        "code"=>400,
                        "info"=>"两次密码不一致"
                    ];
                    echo json_encode($date);
                    exit;
                }
            }else{
                $date=[
                    "code"=>400,
                    "info"=>"输入密码长度在6-12之间"
                ];
                echo json_encode($date);
                exit;
            }
        }else{
            $arr=[
                "status"=>$status
            ];
        }
        if(Db::table("admin")->where('id',$id)->update($arr)){
            $date=[
                "code"=>200,
                "info"=>"修改成功"
            ];
        }else{
            $date=[
                "code"=>400,
                "info"=>"修改失败"
            ];
        }
        echo json_encode($date);
    }
}