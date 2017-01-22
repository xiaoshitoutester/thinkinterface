<?php

/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/19
 * Time: 20:46
 */
namespace app\common\model;
use think\Model;

class User extends Model
{
    /*
     * id 主键 name,username,password,phone,email,type 用户类型
     * type: 用户类型
     * status: 默认1，1正常，0不正常
     */

    // type读取器
    protected function getTypeAttr($type){
        $res = [
            0 => '管理员',
            1 => '普通用户',
        ];
        return $res[$type];
    }
    protected function getUpdateTimeAttr($time){
        return date('Y-m-d H:i:s', $time);
    }
    /*
     * 检查用户名密码是否正确
     */
    public static function checkUserLogin($username, $password){
        $user = User::where(['status'=>1])->where(['username'=>$username])->find();
        if (!empty($user)){
            if ($user->password === md5($password)){
                // 登录成功设置session
                session('loginUser',$user);
                return true;
            }
        }
        return false;
    }
    /*
     * 获取所有正常的用户,status = 1
     */
    public static function getAllUser($where){
        $users = User::where(['status'=>1])->where($where)->select();
        return $users;
    }
}