<?php


namespace app\index\controller;


use think\facade\View;

class Order extends BaseController
{
    public function index(){
        if(!$this->getLoginUser()){
            redirect(url('index/index'));
        }

        // 获取用户id
        $userId = session('o2o_user');
        // 查询用户
        $user = app('app\common\model\User')->find($userId);

        $id = input('get.id', 0, 'intval');
        if(!$id){
            return View::fetch('参数不合法');
        }

        $dealCount = input('get.deal_count', 0);
        $totalPrice = input('get.total_price', 0);

        $deal = app('app\index\model\Deal')->find($id);

        if(!$deal || $deal->status != 1){
            return View::fetch('error');
        }

        // 判断来路
        if(empty($_SERVER['HTTP_REFERER'])){
            return View::fetch('error');
        }

        // 组装订单入库数据
        $orderSn = setOrderSn();
        $data = [
            'out_trade_no' => $orderSn,
            'user_id' => $user->id,
            'username' => $user->username,
            'deal_count' => $dealCount,
            'total_price' => $totalPrice,
            'pay_status' => 1,
            'referer' => $_SERVER['HTTP_REFERER']
        ];
        try{
            $res = $orderId = app('app\index\model\Order')->add($data);
            if(!$res){
                return View::fetch('error');
            }
        }catch (\Exception $e){
            return View::fetch('error');
        }
        return redirect(url('pay/index', ['id' => $orderId]));
    }


    public function confirm(int $id = 1,int  $count = 1){
        if(!$this->getLoginUser()){
            return redirect(url('index/index'));
        }

        $deal = app('app\index\model\Deal')->find($id);
        if(!$deal || $deal->status != 1){
            return View::fetch('error');
        }

        $deal = $deal->toArray();
        View::assign('count', $count);
        View::assign('deal', $deal);
        View::assign('controler', 'pay');
        return View::fetch();
    }
}