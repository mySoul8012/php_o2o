<?php


namespace app\bis\controller;

use think\facade\View;
class Index extends BaseController
{
    protected $middleware = [
        'app\bis\middleware\Check'
    ];

    public function index(){
        return View::fetch();
    }
}