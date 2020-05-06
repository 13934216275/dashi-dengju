<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Types extends Lock
{
    public function index()
    {

        $list=Db::table('types')->paginate(5,false,['query'=>request()->param()]);
        $this->assign('list',$list);
        $list1=Db::table('types')->where('pid',0)->select();
        $this->assign('list1',$list1);
        return view();
    }
    public function insert(){
        $data=input('post.');
        if(Db::table('types')->insert($data)){
            $this->success('添加成功','types/index','',2);
        }else{
            $this->error('添加失败','types/index','',2);
        };

    }
    public function ajax_del(){
        $id=$_POST['id'];
        $data=Db::table('types')->select();
        foreach ($data as $a=>$v){
            $s=$v['pid'];
        }
            if($id==$s){
                $date=[
                    "code"=>400,
                    "info"=>"删除失败"
                ];
            }else{
                if(Db::table('types')->delete($id)){
                    $date=[
                        "code"=>200,
                        "info"=>"删除成功"
                    ];
                }else{
                    $date=[
                        "code"=>400,
                        "info"=>"删除失败"
                    ];
                };
            };
            return $date;

    }
    public function edit(){
        $id=$_POST['id'];
        $data=Db::table('types')->where('id',$id)->select();
        $list=Db::table('types')->select();
        $this->assign('data',$data);
        $this->assign('list',$list);
        return view();
    }
    public function ajax_save(){
        $data=input('post.');
        $id=$data['id'];

        if(Db::table('types')->where('id',$id)->update($data)){
            $this->success('修改成功','types/index','',1);
        }else{
            $this->error('修改失败','types/index','',1);
        };
    }

}