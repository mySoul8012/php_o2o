<?php


namespace app\bis\model;


use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;

    public function getNormalCategoryByParentId(int $parentId = 0){
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