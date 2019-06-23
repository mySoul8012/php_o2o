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
        $user = session('o2o_user');
        if($user){
            return View::fetch('302');
        }
        return View::fetch();
    }

    public function logincheck(){
        // 判断
        if(!$this->request->isPost()){
            return View::fetch('提交非法');
        }

        $data = input('post.');

        // 判断是否相同
        $user =  app('app\common\model\User')->getUserByUsername($data['userName']);

        if(!$user || $user->status != 1){
            return View::fetch('error');
        }

        // 判断密码
        if(md5($data['password'] . $user->code )!= $user->password){
            // 失败
            return View::fetch('error');
        }

        // 登录成功
        app('app\common\model\User')->updateById([
            'last_login_time' => time(),
        ], $user->id);

        // 保存session
        session('o2o_user', (String)$user->id);
        return View::fetch('302');
    }

    /**
     * @return string
     */
    public function register(){
        if($this->request->isPost()){
            $data = input('post.');
            if(!captcha_check($data['verifyCode'])){
                return View::fetch('error');
            }else{
                // 判断两次密码
                if($data['password'] != $data['repassword']){
                    return View::fetch('error');
                }

                $data['last_login_ip'] = $this->request->ip();
                $data['last_login_time'] = time();
                $data['code'] = mt_rand(100,100000);
                $data['password'] = md5($data['password'] . $data['code']);

                $res  = app('app\common\model\User')->add($data);
                if($res) {
                    return View::fetch('success');
                }else{
                    return View::fetch('error');
                }
            }
        }
        return View::fetch();
    }

    // 退出登录
    public function logout(){
        session('o2o_user', null);
        return View::fetch('login');
    }
}