<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Show extends Lock
{
    public function index()
    {
        $search=input("get.search");
        $tot=Db::table('admin')->where("username like '%$search%'")->count();
        $list=Db::table('admin')->where("username like '%$search%'")->paginate(5,false,['query'=>request()->param()]);
        $this->assign('list',$list);
        $this->assign('tot',$tot);
        return view();
    }

}