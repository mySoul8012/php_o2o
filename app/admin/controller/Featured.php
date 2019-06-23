<?php


namespace app\admin\controller;


use think\facade\View;

class Featured extends BaseController
{
    public function index(){
        $res = app('app\admin\model\Featured')->selectAll();
        View::assign("res", $res);
        return View::fetch();
    }

    public function add(){
        if($this->request->isPost()){
            $file = request()->file('image');
            $oss = app('OSS');

            // 入库
            $data = input('post.');
            $data['image'] = $oss->uploadFile($file);
            // 校验

            // 入model层
            $id = app('app\admin\model\Featured')->add($data);

            if($id){
                return View::fetch('success');
            }else{
                return View::fetch('error');
            }
        }


        // 获取推荐位
        $types = app('Featured')->getFeatured();
        View::assign('types', $types);
        return View::fetch();
    }
}