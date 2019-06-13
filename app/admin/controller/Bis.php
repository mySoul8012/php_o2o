<?php


namespace app\admin\controller;


use think\facade\View;

class Bis extends BaseController
{
    public function apply(){
        $bis = app("app\common\model\Bis")->getBisBySyatus();
        View::assign("bis", $bis);
        return View::fetch();
    }

    public function detail($id){
        // 获取一级城市数据
        $citys = app("app\bis\model\City")->getNormalCitysByParentId();
        // 获取一级栏目的数据
        $categorys = app("app\bis\model\Category")->getNormalCategoryByParentId();
        // 商户信息
        $bisData = app("app\common\model\Bis")->find($id);
        View::assign("categorys", $categorys);
        View::assign("citys", $citys);
        return View::fetch();
    }

}