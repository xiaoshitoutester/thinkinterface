<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/18
 * Time: 21:53
 */

namespace app\index\controller;
use app\common\model\User as UserModel;

class Login extends Index
{
    /*
     * 登录页面
     */
    public function index(){
        return $this->fetch();
    }
    /*
     * 处理登录请求
     */
    public function doLogin(){
        $datas = input();
        if (empty($datas['username']) || empty($datas['password'])){
            $res['code'] = 500;
            $res['message'] = '用户名或者密码不能为空';
            return json($res);
        }
        if (UserModel::checkUserLogin($datas['username'], $datas['password'])){
            $res['code'] = 200;
            $res['message'] = '登录成功';
            return json($res);
        }
        $res['code'] = 500;
        $res['message'] = '用户名或者密码错误';
        return json($res);
    }
}