<?php
namespace app\admin\Controller;
use think\Controller;
use think\Db;

class Comment extends Lock{

    public function index(){
        $resss=Db::table("comment")
            ->field("comment.*,user.username,news.title,news.img")
            ->join("user","comment.uid=user.id")
            ->join("news","comment.nid=news.id")
            ->paginate(4);
        $tot=Db::table("comment")->count();
        $this->assign("list",$resss);
        $this->assign("tot",$tot);
        return view();
    }


    public function gai(){
        $id=input("post.id");
        $status=input("post.status");
        $res=Db::table("comment")->where("id",$id)->update(["status"=>$status]);
        if($res){
            $data=[
                "code"=>200,
                "info"=>"修改成功"
            ];
        }else{
            $data=[
                "code"=>400,
                "info"=>"修改失败"
            ];
        }
        return $data;
    }

    //批量删除数据
    public function shan(){
        $id=input("post.id");





        $res=Db::table('comment')->delete($id);
        if($res){
            $data=[
                "code"=>200,
                "info"=>"删除成功"
            ];


        }else{
            $data=[
                "code"=>400,
                "info"=>"删除失败"
            ];
        }
        echo json_encode($data);
    }



}