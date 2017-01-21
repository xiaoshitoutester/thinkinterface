<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/21
 * Time: 18:45
 */

namespace app\index\controller;


class UserManage extends Index
{
    public function index()
    {
        return $this->fetch();
    }

}