<?php
namespace app\admin\controller;


use think\exception\ValidateException;
use think\facade\View;
class Category extends BaseController
{
    public function index(){
        return View::fetch();
    }

    public function add(){
        return View::fetch();
    }

    public function save(){
        // 需要进行规则校验
        $data = input('post.');
        try{
            validate(\app\admin\validate\Category::class)->scene('add')->check($data);
        }catch (ValidateException $e){
            View::assign('errorMessage', $e->getError());
            return View::fetch('error');
        }
        return View::fetch('success');
    }
}