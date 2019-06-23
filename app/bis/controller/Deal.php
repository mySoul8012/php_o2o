<?php


namespace app\bis\controller;


use think\facade\View;

class Deal extends BaseController
{
    public function index(){
        // 从session中获取id
        $id = session('bisAccount');
        $data = app('app\bis\model\Deal')->where([
            'bis_id' => $id
        ])->select();
        View::assign('data', $data);
        return View::fetch();
    }

    public function add(){
        if($this->request->isPost()){
            $data = input('post.');
            $file = request()->file('image');
            $data['image'] = app('OSS')->uploadFile($file);
            $res = app('app\bis\model\Deal')->insertAddAll($data, session('bisAccount'));
            if($res){
                return View::fetch('success');
            }else{
                return View::fetch('error');
            }
        }
        // 获取一级城市数据
        $citys = app("app\bis\model\City")->getNormalCitysByParentId();
        View::assign('citys', $citys);
        // 获取一级栏目的数据
        $categorys = app("app\bis\model\Category")->getNormalCategoryByParentId();
        View::assign("categorys", $categorys);
        return View::fetch();
    }
}