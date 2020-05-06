<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class User extends Lock
{
    public function index()
    {
        $search=input("get.search");
        $tot=Db::table('user')->where("username like '%$search%'")->whereOr("phone like '%$search%'")->whereOr("email like '%$search%'")->count();
        $list=Db::table('user')->where("username like '%$search%'")->whereOr("phone like '%$search%'")->whereOr("email like '%$search%'")->paginate(5,false,['query'=>request()->param()]);
        $this->assign('list',$list);
        $this->assign('tot',$tot);
        return view();
    }
    public function ajax_bai(){
        $bai=$_GET['status'];
        $id=$_GET['id'];
        $bb=Db::table("user")->where("id",$id)->update(['status'=>$bai]);
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

}