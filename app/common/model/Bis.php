<?php


namespace app\common\model;


class Bis extends BaseModel
{
    public function getBisBySyatus($status=1){
        $order = [
            'id' => 'desc',
        ];

        $data = [
            'status' => $status
        ];
        return $this->where($data)->order($order)->paginate();
    }
}