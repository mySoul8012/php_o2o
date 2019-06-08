<?php


namespace app\admin\validate;

use think\Validate;
class Category extends \think\Validate
{
    // 规则属性
    protected $rule = [
        'name' => 'require|max:10',
        'parent_id' => 'number',
        'id' => 'number',
        'status' => 'number|in:-1,0,1',
        'listorder' => 'number'
    ];

    protected $message = [
        'name.require' => '分类名必须输入',
        'name.max' => '长度不能超过10',
        'parent_id.require' => 'id错误'
    ];

    protected $scene = [
        'add' => [
            // 添加
            'name', 'parent_id'
        ],
        'listorder' => [
            // 排序
            'id', 'listorder'
        ]
    ];
}