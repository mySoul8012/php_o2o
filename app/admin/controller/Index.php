<?php
namespace app\admin\controller;

use Email;
use Map;
use OSS\Core\OssException;
use OSS\OssClient;
use think\facade\Env;
use think\facade\View;
class Index extends BaseController
{
    public function index(){
        return View::fetch();
    }



    public function welcome(){
        return "欢迎来到O2O管理后台";
    }

    public function test(){
           return View::fetch();
    }

    public function test1(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        if($file){
            $info = $file->move('/home/ming/PhpstormProjects/untitled14/public/uploads');
            if($info){
                dump($info->getFilename());
                dump($info->getSaveName());
                $path = "/home/ming/PhpstormProjects/untitled14/public/uploads/" . $info->getSaveName();
                $url = app('OSS')->upload($path, $info->getFilename());
                dump($url);
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}