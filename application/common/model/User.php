<?php

/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/19
 * Time: 20:46
 */
namespace app\common\model;

class User extends \think\Model
{
    /*
     * id 主键 name,username,password,phone,email,type 用户类型
     * type: 用户类型
     * status: 默认1，1正常，0不正常
     */
    /*
     * 检查用户名密码是否正确
     */
    public static function checkUserLogin($username, $password){
        $user = User::where(['status'=>1])->where(['username'=>$username])->find();
        if (!empty($user)){
            if ($user->password === md5($password)){
                // 登录成功设置session
                session('loginSuccess',$user);
                return true;
            }
        }
        return false;
    }
}