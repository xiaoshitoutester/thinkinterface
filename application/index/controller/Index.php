<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // 验证用户是否已经登录
        if (is_null(session('loginUser'))){
            // 未登录,返回登录页面
            return $this->redirect('Login/index');
        }

    }

    public function index(){
        return $this->redirect('Login/index');
    }
}
