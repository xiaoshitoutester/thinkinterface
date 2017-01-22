<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/21
 * Time: 18:45
 */

namespace app\index\controller;
use app\common\model\User as UserModel;

class UserManage extends Index
{
    /*
     * 用户管理页面
     */
    public function index()
    {
        $users = UserModel::getAllUser();
        $this->assign('users', $users);
        return $this->fetch();
    }
    /*
     * 新增用户
     */
    public function addUser(){
        $parms = input();
        // 获取插入的参数
        $data = [
            'username' => $parms['username'],
            'password' => md5($parms['password']),
            'name' => $parms['name'],
            'type' => $parms['type'],
            'phone' => $parms['phone'],
            'email' => $parms['email'],
        ];
        $userModel = new UserModel();
        if ($userModel->save($data)){
            $res['code'] = 200;
            $res['message'] = '新增用户成功';
            return json($res);
        }
        $res['code'] = 500;
        $res['message'] = '新增用户失败';
        return json($res);
    }


}