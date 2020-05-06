<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function _initialize()
    {
        $nav=Db::table('nav')->select();
        $this->assign('nav',$nav);
    }

    public function index()
    {
        $banner=Db::table('banner')->select();
        $this->assign('banner',$banner);
        return view();
    }
    public function blog()
    {
        if($_GET){
            $typeid=$_GET['id'];
            $data=Db::table('news')->find($typeid);
            $this->assign('data',$data);
        }else{
            $data=null;
            $this->assign('data',$data);
        }
        $type=Db::table('types')->select();
        $list1=Db::table('types')->join('news',"types.id=news.typeid")->where('typeid',1)->select();
        $list2=Db::table('types')->where('typeid',2)->join('news',"types.id=news.typeid")->select();
        $list3=Db::table('types')->where('typeid',8)->join('news',"types.id=news.typeid")->select();
        $list4=Db::table('types')->where('typeid',7)->join('news',"types.id=news.typeid")->select();
        $list5=Db::table('types')->where('typeid',6)->join('news',"types.id=news.typeid")->select();
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->assign('list3',$list3);
        $this->assign('list4',$list4);
        $this->assign('list5',$list5);
        $this->assign('type',$type);

        return view();
    }
    public function lianxi()
    {
        return view();
    }
    public function xiangqing()
    {
        $id=$_GET['id'];
        $type=Db::table('types')->select();
        $data=Db::table('news')->find($id);
        $this->assign('data',$data);
        $this->assign('type',$type);

        $pre=Db::table("news")
            ->where("id<$id")
            ->limit(1)
            ->select();
        $this->assign("pre",$pre);
        $nex=Db::table("news")
            ->where("id>$id")
            ->limit(1)
            ->select();
        $this->assign("nex",$nex);

        return view();
    }
    public function introduction()
    {
        return view();
    }
}