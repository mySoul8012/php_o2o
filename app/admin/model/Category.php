<?php


namespace app\admin\model;


use think\Model;

class Category extends Model
{
    // 自动插入当前时间
    protected $autoWriteTimestamp = true;

    public function add($data){
        // 状态值1
        $data['status'] = 1;
        return $this->save($data);
    }

    /**
     * 获取所有栏目
     */
    public function getNormalFistCategory(){
        $data = [
            'status' => 1,
            'parent_id' => 0
        ];

        $order = [
            // 倒序
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }

    /**
     * 获取一级目录
     */
    public function getFirstCategorys($parentId = 0){
        $data = [
            'parent_id' => $parentId,
            'status' => [
                '1', '0'
            ]
        ];

        // 排序
        $order = [
            "listorder" => "desc",
            'id' => 'desc'
        ];


        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }

}