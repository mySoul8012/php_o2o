<?php


namespace app\common\model;


use think\Exception;
use think\Model;

class User extends Model
{

    public function add($data){

        $data['status'] = 1;
        unset($data['repassword']);
        unset($data['verifyCode']);

        return $this->insert($data);
    }

    public function getUserByUsername($username){
        $data = [
            'username' => $username
        ];

        return $this->where($data)->find();
    }

    public function updateById($data, $id){
        return $this->update($data, [
            'id' => $id
        ]);
    }
}