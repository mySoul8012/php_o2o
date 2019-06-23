<?php


namespace app\common\model;


use think\Model;

class Category extends Model
{
    public function getNormalRecommendCategoryByParentId($id = 0, $limit = 5){
        $data = [
            'parent_id' => $id,
            'status' => 1
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        $res = $this->where($data)->order($order);
        if($limit){
            $res = $res->limit($limit);
        }
        return $res->select();
    }

    public function getNormalCategoryIdParentId($ids){
        $data = [
            'parent_id' => ['id', implode(',', $ids)],
            'status' => 1,
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        $res = $this->where($data)->order($order)->select();
        return $res;
    }
}