<?php
namespace app\api\controller;

use Map;
use think\App;
use think\exception\ValidateException;
use think\facade\View;
use think\Model;
class Category extends BaseController
{
    public function getCategoryByParentId(int $id = 0){
        $category = app("app\bis\model\Category")->getNormalCategoryByParentId($id);
        if($category) {
            $data = [
                'status' => 1,
                'message' => 'success',
                'data' => $category
            ];
        }else{
            $data = [
                'status' => 0,
                'message' => 'error',
                'data' => $category
            ];
        }
        return json($data);
    }
}