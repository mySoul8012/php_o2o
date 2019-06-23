<?php


namespace app\bis\controller;

use Map;
use think\facade\View;

class Register
{

    public function index(){
        // 获取一级城市数据
        $citys = app("app\bis\model\City")->getNormalCitysByParentId();
        // 获取一级栏目的数据
        $categorys = app("app\bis\model\Category")->getNormalCategoryByParentId();
        View::assign("categorys", $categorys);
        View::assign("citys", $citys);
        return View::fetch();
    }

    public function add(){
        if(!request()->isPost()){
            return 'error';
        }

        $data = input('post.');

        $oss = app('OSS');
        $files = request()->file('image');
        $data['logo'] = $oss->uploadFile($files[0]);
        $data['licence_logo'] = $oss->uploadFile($files[1]);
        // 获取经纬度
        $lnglat = \Map::getLngLat($data["address"]);
        if(empty($lnglat)){
            return "无法获取数据";
        }

        // 信息入库
        // 商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' : $data['description'],
            'bank_info' =>  $data['bank_info'],
            'bank_user' =>  $data['bank_user'],
            'bank_name' =>  $data['bank_name'],
            'faren' =>  $data['faren'],
            'faren_tel' =>  $data['faren_tel'],
            'email' =>  $data['email'],
        ];

        $bisId = app("app\bis\model\Bis")->add($bisData);
        
        // 总店相关信息入库
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'logo' => $data['logo'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'],
            'api_address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 1,// 代表的是总店信息
            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
        ];

        $locationId = app("app\bis\model\BisLocation")->add($locationData);

        $data['code'] = mt_rand(100, 1000);
        $accounData = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'code' => $data['code'],
            'password' =>  md5($data['password'].$data['code']),
            'is_main' => 1
        ];

        $accountId = app("app\bis\model\BisAccount")->add($accounData);
        if(!$accountId){
            return View::fetch('error');
        }

        // 发送邮件
        $url = request()->domain().url('bis/register/waiting', ['id' => $bisId]);
        $title = 'o2o入驻申请通知';
        $content = "请您点击连接申请<a href='" . $url . "' target='_blank'>查看审核状态</a>";
        app("Email")->sendMail($data['email'], $title, $content);
        return View::fetch('success');
    }

    public function waiting($id){
        if(empty($id)){
            return View::fetch('error');
        }
        $detail = app('app\bis\model\Bis')->find($id);

        View::assign('detail', $detail);
        return View::fetch();
    }
}