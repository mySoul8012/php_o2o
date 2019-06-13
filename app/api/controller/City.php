<?php
namespace app\api\controller;

use Map;
use think\App;
use think\exception\ValidateException;
use think\facade\View;
use think\Model;
class City extends BaseController
{
    public function getcitysbyparentid(int $id = 0){
        $citys = app("app\bis\model\City")->getNormalCitysByParentId($id);
        $res = [
            'status' => 1,
            "message" => "success",
            'data' => $citys
        ];
        return json($res);
    }
}