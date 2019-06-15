<?php


namespace app\admin\controller;


use think\facade\View;

class Deal extends BaseController
{
    public function index(){
        // 栏目分类
        $categorys = app('\app\bis\model\Category')->getNormalCategoryByParentId();
        $city = app('\app\bis\model\City')->getNormalCitys();
        $data = input('get.');
        $sdata = [];
        // 进行判空
        if(!empty($data['startDate']) && !empty($data['endDate']) && strtotime($data['startDate']) < strtotime($data['endDate'])){
            $sdata['create_time'] = [
                'gt' => strtotime($data['startDate']),
                'lt' => strtotime($data['endDate'])
            ];
        }

        // 模糊查询
        if(!empty($data['groupName'])){
            $sdata['name'] = [
                'like', '% '  .  $data['groupName'] .'%'
            ];
        }

        $deals = app("app\admin\model\Deal")->getNormalDeals($sdata);



        View::assign('categorys', $categorys);
        View::assign('citys', $city);
        View::assign('deals', $deals);
        return View::fetch();
    }
}