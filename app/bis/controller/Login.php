<?php
namespace app\bis\controller;


use think\facade\View;

class Login extends BaseController
{
    public function login(){
        return View::fetch();
    }
}