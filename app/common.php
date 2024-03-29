<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 状态转换
 * @param $status
 */
function status($status){
    if($status === 1){
        $str = "<span class='label label-success radio'>正常</span>";
    }elseif ($status === 0){
        $str = "<span class='label label-danger radio'>待审</span>";
    }elseif ($status === -1){
        $str = "<span class='label label-danger radio'>删除</span>";
    }

    return $str;
}


// curl
/**
 * @param $url
 * @param int $type 0 get  1 post
 * @param array $data
 */
function doCurl($url, $type=0, $data=[]) {
    $ch = curl_init(); // 初始化
    // 设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER,0);

    if($type == 1) {
        // post
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行并获取内容
    $output = curl_exec($ch);
    // 释放curl句柄
    curl_close($ch);
    return $output;
}

function bisRegister($status){
    if($status == 1){
        $str = "入驻申请成功";
    }elseif($status == 0){
        $str = "待审核 审核后会发送邮件通知";
    }elseif ($status == 2){
        $str = "非常抱歉，请您重新提交";
    }else{
        $str = "该申请已经删除";
    }
    return $str;
}

// 订单号生成
function setOrderSn(){
    list($t1, $t2) = explode(' ', microtime());
    $t3 = explode('.', $t1 * 100000);
    return $t2.$t3[0].(rand(10000, 9999999));

}