<?php


namespace app\admin\model;


use think\Model;

class Featured extends Model
{
    public function add($data){
        return $this->insert($data);
    }

    public function selectAll(){
        return $this->select();
    }
}