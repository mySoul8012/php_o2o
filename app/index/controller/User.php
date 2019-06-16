<?php
namespace app\index\controller;


use think\captcha\Captcha;
use think\captcha\CaptchaController;
use think\facade\View;
class User extends BaseController
{
    public function index(){

    }

    public function login(){
        return View::fetch();
    }

    /**
     * @return string
     */
    public function register(){
        if(!$this->request->isPost()){
            $data = input('post.');
            if(captcha_check($data['verifyCode'])){
                echo 4;
            }
        }
        return View::fetch();
    }
}