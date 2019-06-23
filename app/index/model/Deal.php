<?php


namespace app\index\model;


use think\Model;

class Deal extends Model
{
    /**
     *  根据分类 以及城市获取商品数据
     * @param $id
     * @param $cityId
     * @param int $limit
     */
    public function getNormalDealByCategoryCityId($id, $cityId, $limit = 10){
        $data = [
            'category_id' => $id,
            'city_id' => $cityId,
            'status' => 1,
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];

        $res = $this->where($data)->order($order);
        if($limit){
            $res = $res->limit($limit);
        }
        $res = $res->select();
        return $res;
    }
}