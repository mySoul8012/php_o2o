<?php


namespace app\bis\model;


use think\Model;

class City extends Model
{
    protected $autoWriteTimestamp = true;


    public function getNormalCitysByParentId(int $parentId = 0){
        $data = [
            'status' => 1,
            'parent_id' => $parentId
        ];

        $order = [
            // 倒序
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }

}