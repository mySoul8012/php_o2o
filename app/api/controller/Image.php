<?php


namespace app\api\controller;


use think\facade\Request;

class Image extends Controller
{
    public function upload(){
        $file = Request::instance()->file('file');
        // 目录
        $info = $file->move('upload');
        print_r($info);
    }
}