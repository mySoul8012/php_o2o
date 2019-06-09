<?php
namespace app\admin\controller;

use Map;
use think\facade\View;
class Index extends BaseController
{
    public function index(){

        return View::fetch();
    }


    public function welcome(){
        return "欢迎来到O2O管理后台";
    }
}