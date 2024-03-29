<?php


namespace app\common\model;


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

    /**
     * 获取省级数据
     */
    public function getNormalCitys(){
        $data = [
            'status' => 1,
            'parent_id' => [
                'gt', 0
            ],
        ];

        $order = ['id' => 'desc'];

        return $this->where($data)->order($order)->select();
    }

}