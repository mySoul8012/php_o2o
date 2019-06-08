<?php
namespace app\admin\controller;

use think\facade\View;
class Index
{
    public function index(){
        return View::fetch();
    }

    public function welcome(){
        return "欢迎来到O2O管理后台";
    }
}