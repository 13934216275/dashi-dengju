<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class News extends Lock
{
    public function index()
    {
        $search=input("get.search");
        $typeid=input("get.typeid");
        $sort=input("get.sort");

        switch ($sort){
            case "0":$str1='id desc';break;
            case "1":$str1='num desc';break;
            case "2":$str1='zannum desc';break;
            default:$str1='id desc';
        }
        $types=Db::table('types')->select();
        $tot=Db::table('news')
            ->count();
        if($typeid){
            $list=Db::table('news')
                ->order($str1)
                ->field("news.*,types.name")
                ->join('types','news.typeid=types.id')
                ->where("title like '%$search%' and typeid=$typeid")
                ->paginate(5,false,['query'=>request()->param()]);
            $this->assign('list',$list);
        }else{
            $list=Db::table('news')
                ->order($str1)
                ->field("news.*,types.name")
                ->join('types','news.typeid=types.id')
                ->where("title like '%$search%'")
                ->paginate(5,false,['query'=>request()->param()]);
            $this->assign('list',$list);
        }


        $this->assign('tot',$tot);
        $this->assign('type',$types);
        $this->assign('typeid',$typeid);
        $this->assign('sort',$sort);
        return view();
    }
    public function add(){
        $list=Db::table('types')->select();
        $this->assign('list',$list);
        return view();
    }
    public function show(){
        $id=$_POST['id'];

        $list=Db::table('news')
           ->where('id',$id)->find();
        $idd=$list['typeid'];
        $data=Db::table('types')->where('id',$idd)->find();
        $list['name']=$data['name'];
        $this->assign('list',$list);
        return view();
    }
    public function insert(){
        $data=input('post.');
        $file=request()->file('img');
        $data['time']=date('Y-m-d,H:i:s',time());
        $info = $file->move(ROOT_PATH.'public/upload/news/');
        if($info){
            $img= $info->getSaveName();
            $data['img']=$img;
        }else{
            echo $file->getError();
        }
        if(Db::table('news')->insert($data)){
            $this->success('添加成功',"news/index",'',1);
        }else{
            $this->error('添加失败',"news/index",'',1);
        };
    }
    public function ajax_num(){
        $data=input('get.');
        if(Db::table('news')->update($data)){
            $data0=[
                "code"=>200,
                "info"=>"修改成功"
            ];
        }else{
            $data0=[
                "code"=>200,
                "info"=>"修改失败"
            ];
        }
        return $data0;
    }
    public function ajax_zannum(){
        $data=input('get.');
        if(Db::table('news')->update($data)){
            $data0=[
                "code"=>200,
                "info"=>"修改成功"
            ];
        }else{
            $data0=[
                "code"=>200,
                "info"=>"修改失败"
            ];
        }
        return $data0;
    }
    public function ajax_del(){
        $id=$_POST['id'];
        $img=$_POST['img'];
        if(Db::table('news')->delete($id)){
            unlink('upload/news/'.$img);
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
        return $date;
    }

}