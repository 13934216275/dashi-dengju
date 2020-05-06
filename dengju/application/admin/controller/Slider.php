<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Slider extends Lock
{
    public function index()
    {
        $search=input("get.search");
        $tot=Db::table('banner')->where("sort like '%$search%'")->whereOr("name like '%$search%'")->count();
        $list=Db::table('banner')->order('sort','desc')->where("sort like '%$search%'")->whereOr("name like '%$search%'")->paginate(5,false,['query'=>request()->param()]);
        $this->assign('list',$list);
        $this->assign('tot',$tot);
        return view();
    }
    public function insert(){
        $post=input('post.');
        $file=request()->file('img');
        $info=$file->move(ROOT_PATH ."public/upload/slider");
        if($info){
            $img=$info->getSaveName();
        }else{
            echo $file->getError();
        }
        $post['img']=$img;
        $res=Db::table('banner')->insert($post);
        if($res){
            $this->success('上传成功', 'Slider/index','',3);
        }else{
            $this->error('上传失败', 'Slider/index','',3);
        }
    }
    public function ajax_sort(){
        $data=input('get.');
        if(Db::table('banner')->update($data)){
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
        $id=input('get.id');
        $data=Db::table('banner')->where('id',$id)->find();
        $img='upload/slider/'.$data['img'];
        $res=Db::table('banner')->delete($id);
        if($res){
            unlink("$img");
            $data0=[
                "code"=>200,
                "info"=>"删除成功"
            ];
        }else{
            $data0=[
                "code"=>400,
                "info"=>"删除失败"
            ];
        };

        return $data0;
    }
    public function ajax_delee(){
        $str=input("post.");
       $idstr=$str['idstr'];
       $imgstr=$str['imgstr'];
        $idarr=explode(',',$idstr);
        $imgarr=explode(',',$imgstr);
        foreach ($idarr as $a=>$v){
            $data=Db::table("banner")->delete($v);
            if($data){
                foreach ($imgarr as $c=>$s){
                    unlink('upload/slider/'.$s);
                }
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
    public function updt(){
        $id=$_GET['id'];
        $data=Db::table('banner')->find($id);
        $this->assign('data',$data);
        return view();
    }
    public function ajax_save(){
        $data=input("post.");
        $name=$data['name'];
        $sort=$data['sort'];
        $oldimgs=$data['imgs'];
        $id=$data['id'];
        $file1=request()->file('img1');
        $arr=[];
        if($file1){
            $info=$file1->move(ROOT_PATH ."public/upload/slider");
            if($info){
                $img=$info->getSaveName();
                $arr['img']=$img;
            }else{
                echo $file1->getError();
            }
            $arr['name']=$name;
            $arr['sort']=$sort;
            if(Db::table("banner")->where('id',$id)->update($arr)){
                unlink('upload/slider/'.$oldimgs);
                $this->success('修改成功', 'Slider/index','',2);
            }else{
                $this->error('修改失败', 'Slider/index','',2);
            }
        }else{
            $arr['name']=$name;
            $arr['sort']=$sort;
            if(Db::table("banner")->where('id',$id)->update($arr)){
                $this->success('修改成功', 'Slider/index','',2);
            }else{
                $this->error('修改失败', 'Slider/index','',2);
            }
        }


    }


}