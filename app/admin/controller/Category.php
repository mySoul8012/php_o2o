<?php
namespace app\admin\controller;


use think\App;
use think\exception\ValidateException;
use think\facade\View;
use think\Model;
class Category extends BaseController
{

    public function index(){
        $parentId = input('get.parent_id', 0, 'intval');
        $result = app('\app\admin\model\Category')->getFirstCategorys($parentId);
        View::assign('category', $result);
        return View::fetch();
    }

    /**
     * 添加
     * @return string
     */
    public function add(){
        $data = app('\app\admin\model\Category')->getNormalFistCategory();
        View::assign('category', $data);
        return View::fetch();
    }

    /**
     * 保存页面
     * @return string
     */
    public function save(){
        // 判断是否为post提交
        if(!$this->request->isPost()){
            return View::fetch("error");
        }



        // 需要进行规则校验
        $data = input('post.');
        try{
            validate(\app\admin\validate\Category::class)->scene('add')->check($data);
        }catch (ValidateException $e){
            View::assign('errorMessage', $e->getError());
            return View::fetch('error');
        }

        // 进行更新超过
        if(!empty($data['id'])){
            return $this->update($data);
        }

        $res = app('\app\admin\model\Category')->add($data);
        if($res){
            return View::fetch('success');
        }
        return View::fetch('error');
    }

    /**
     * 编辑页面
     */
    public function edit($id = 0){
        if(intval($id) < 1){
            return View::fetch('error');
        }

        $category = app('\app\admin\model\Category')->find($id);
        $categorys = app('\app\admin\model\Category')->getNormalFistCategory();
        View::assign("category", $category);
        View::assign("categorys", $categorys);
        return View::fetch();
    }

    /**
     *
     * 排序
     * @param int $id
     * @param int $listorder
     */
    public function listorder($id = 0, $listorder = 0){
        // 判断是否为post提交
        if(!$this->request->isPost()){
            return View::fetch("error");
        }

        $res = app('\app\admin\model\Category')->update([
            'listorder' => $listorder
        ], [
            'id' => $id
        ]);

        if($res){
            return  json([
                // 状态码
                "SERVER" => $_SERVER['HTTP_REFERER'],
                // 更新标志位
                "flag" => 1,
                // 消息内容
                "data" => [
                    'message' => "success"
                ],
                "time" => time()
            ]);
        }else{
            return json([
                "SERVER" => $_SERVER['HTTP_REFERER'],
                "flag" => 0,
                'data' => [
                    'message' => 'error'
                ],
                "time" => time()
            ]);
        }
    }

    private function update($data){
        $res = app('\app\admin\model\Category')->update($data, [
            'id' => $data['id']
        ]);

        if($res){
            return View::fetch('success');
        }else{
            return View::fetch("error");
        }
    }
}