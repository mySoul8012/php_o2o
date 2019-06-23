<?php


namespace app\index\controller;


use think\facade\View;

class Index extends BaseController
{
    public function index(){
        $datas = app('app\index\model\Deal')->getNormalDealByCategoryCityId(16, $this->city->id);
        $meishicates = app('app\common\model\Category')->getNormalRecommendCategoryByParentId(1, 4);
        View::assign("meishicates", $meishicates);
        View::assign('datas', $datas);
        View::assign('title', '首页');
        return View::fetch();
    }
}