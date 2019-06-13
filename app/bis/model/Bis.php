<?php


namespace app\bis\model;


use think\Model;

class Bis extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 1;
        $this->save($data);
        return $this->id;
    }
}