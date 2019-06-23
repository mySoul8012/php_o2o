<?php


namespace app\index\model;


use think\Model;

class Order extends Model
{
    public function add($data){
        $data['status'] = 1;
        return $this->insert($data);
    }
}