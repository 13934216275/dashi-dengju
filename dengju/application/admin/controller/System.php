<?php
namespace app\admin\controller;
use think\Controller;
class System extends Lock
{
    public function index()
    {
        return view();
    }
    public function insert(){
        $data=input('post.');
        $config=config('Webconfig');
        $img=$config['LOGO'];
        $file=request()->file('LOGO');
        if($file){
            $info=$file->move(ROOT_PATH ."public/upload/system");
            $config['LOGO']=$info->getSaveName();
        }else{
//            $this->error('未修改LOGO','system/index','',1);
            echo "<script> window.location.href='system/index'</script>";
        }
        $arr=array_merge($config,$data);
        $str="<?php return  ".var_export($arr,true).";";
        $s=file_put_contents("../application/extra/webconfig.php",$str);
        if($s){
            if($file){

                    unlink("upload/system/".$img);

            }
            $this->redirect("system/index");
        }else{
            $this->redirect("system/index");
        }
    }

}