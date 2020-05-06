<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Navindex extends Lock
{
    public function index()
    {
        $search=input("get.search");
        $tot=Db::table('nav')->where("name like '%$search%'")->count();
        $list=Db::table('nav')->where("name like '%$search%'")->order('sort desc')->paginate(5,false,['query'=>request()->param()]);
        $this->assign('nav_list',$list);
        $this->assign('tot',$tot);
        return view();
    }
    public function ajax_name()
    {
        $name=input('get.name');
        $sql=Db::table("nav")->where('name',$name)->find();
        if($sql){
            echo 1;
        }else{
            echo 0;
        }
    }
    public function adddata()
    {
        $post=input('post.');
        $name=$post['name'];
        $url=$post['url'];
        $sort=$post['sort'];
        if($name){
            if(strlen($name)>=6&&strlen($name)<=12){
                $sql=Db::table("nav")->where('name',$name)->find();
                if(!$sql){
                    if($url){
                                $data=[
                                    'name'=>$name,
                                    'url'=>$url,
                                    'sort'=>$sort
                                ];
                                $sql=Db::table("nav")->insert($data);
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
                            "info"=>"请输入地址"
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
        $data=Db::table("nav")->delete($str);
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

}