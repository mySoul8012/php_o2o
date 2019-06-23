<?php


namespace app\index\controller;


use think\facade\View;

class Detail extends BaseController
{
    public function index($id){

        // 根据id查询目前的数据
        $res = app('app\index\model\Deal')->find($id);
        if($res->status != 1){
            return View::fetch('error');
        }
        // 获取分类信息
        $category = app('app\common\model\Category')->find($res->category_id);

        View::assign('overplus', $res->total_count - $res->buy_count);
        View::assign('deal', $res);
        View::assign('title', $res->name);
        View::assign('category', $category);
        return View::fetch();
    }
}