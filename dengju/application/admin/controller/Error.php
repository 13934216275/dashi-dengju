<?php
namespace app\admin\controller;
use think\Controller;
class Error extends Lock{
    public function _empty(){
        $this->redirect("admin/index/index");
    }
}