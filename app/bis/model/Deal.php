<?php


namespace app\bis\model;


use think\Model;

class Deal extends Model
{
    public function insertAddAll($data, $id){
        $data['status'] = 1;
        $data['bis_id'] = $id;
        return $this->insert($data);
    }
}