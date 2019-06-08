<?php


namespace app\index\controller;


use think\facade\View;

class Index extends BaseController
{
    public function index(){
        return View::fetch();
    }
}