<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app\index\controller;

use think\App;
use think\exception\ValidateException;
use think\facade\View;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    public $city = "";
    public $accout = "";

    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
        // 城市数据
        $citys = app('app\common\model\City')->getNormalCitys();
        View::assign('citys', $citys);
        $citys = $citys->toArray();
        if(session('cityuname') && !input('get.city')){
            $cityuname = session('cityuname');
        }else {
            $cityuname = input('get.city', $citys[0], 'trim');
            session('cityuname', $cityuname);
        }

        $this->city = app('app\common\model\City')->where([
            'uname' => $cityuname
        ])->find();
        View::assign('city', $this->city);
        // 用户数据
        $this->accout = session('o2o_user');
        // 获取用户名
        $this->accout = app('app\common\model\User')->where([
            'id' => $this->accout
        ])->find();
        View::assign('user', $this->accout);

        // 获取首页分类数据
        $cats = $this->getRecommendCats();
        View::assign('cats', $cats);

        // 加载css
        View::assign('controler', strtolower(request()->controller()));

        View::assign('title', 'O2O首页');
    }

    protected function getLoginUser(){
        if(session("?o2o_user")){
            return true;
        }
        return false;
    }



    /**
     * 获取首页推荐位当中的商品分类数据
     */
    public function getRecommendCats(){
        $parentIds = $sedcatArr = $rescomCats = [];
        $cats = app('app\common\model\Category')->getNormalRecommendCategoryByParentId(0, 5);

        foreach ($cats as $cat){
            $parentIds[] = $cat->id;
        }
        // 获取二级分类
        $sedCats = app('app\common\model\Category')->getNormalCategoryIdParentId($parentIds);
        // 组装
        foreach ($sedCats as $sedCat){
            $sedcatArr[$sedCat->parent_id][] = [
                'id' => $sedCat->id,
                'name' => $sedCat->name
            ];
        }




        foreach ($cats as $cat){
            // recomCats 一级分类 二级数据 [] 第一个参数一级分类的name 第二个参数为二级分类的数据
            $rescomCats[$cat->id] = [$cat->name, empty($sedcatArr[$cat->id])?[]:$sedcatArr[$cat->id]];
        }

        return $rescomCats;

    }




    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

}
