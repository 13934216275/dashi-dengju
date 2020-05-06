<?php
namespace app\admin\controller;
use think\Controller;
class Lock extends Controller{
    public function _initialize(){
        if(session("lock_username") && session("lock_id")){

        }else{
            $this->redirect("login/index");
        }

    }
}