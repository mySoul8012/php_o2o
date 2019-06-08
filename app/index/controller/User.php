<?php


namespace app\index\controller;


use think\facade\View;

class User extends BaseController
{
    public function index(){

    }

    public function login(){
        return View::fetch();
    }

    public function register(){
        return View::fetch();
    }
}