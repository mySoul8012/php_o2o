<?php


namespace app\bis\controller;


use think\facade\Route;
use think\facade\Session;
use think\facade\View;

class Login extends BaseController
{
    public function index(){
        if($this->request->isPost()){
            $data = input('post.');
            $res = app("app\bis\model\BisAccount")->where('username', $data['username'])->find();

            // 判断账户状态，判断结果
            if($res->status == 1 || !$res){
                return View::fetch("error");
            }

            // 密码验证
            if($res->password != md5($data['password'].$res->code)){
                return View::fetch("error");
            }

            // 保存用户信息
            session('bisAccount', $res);
            return View::fetch('302');
        }else{
            // 获取session 判断重复访问
                if(session('?bisAccount')){
                    return View::fetch('/index/index');
                }
            return View::fetch("login");
        }
    }
}