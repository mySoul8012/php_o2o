<?php


namespace app\bis\controller;

use think\facade\View;
class Index extends BaseController
{
    public function index(){
        return View::fetch();
    }
}