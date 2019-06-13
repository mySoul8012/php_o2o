<?php


namespace app\bis\model;


use think\Model;

class BisAccount extends Model
{
    public function add($accounData){
        return $this->insert($accounData);
    }
}