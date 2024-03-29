<?php
/*
 *  公共model类
 * */

namespace app\common\model;


use think\Model;
class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }
}