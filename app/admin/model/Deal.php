<?php


namespace app\admin\model;


use think\Model;

class Deal extends Model
{
    public function getNormalDeals($data = []){
        $data['status'] = 1;
        $order = [
            'id', 'desc'
        ];
        $res = $this->where($data)->paginate();
        //dump($this->getLastSql());
        return $res;
    }
}