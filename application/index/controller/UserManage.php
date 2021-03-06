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
        if (empty(input('page'))){
            $currPage = 1;
        }else{
            $currPage = input('page');
        }
        $users = $this->readUser();
        $data = FenYe($users, 5, $currPage);
        $this->assign('userNumbers', count($users));
        $this->assign('users', $data[0]);
        $this->assign('currPage', $currPage);
        $this->assign('pageCount',$data[1]);
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

    // 私有方法根据条件，获取满足条件的所有用户
    private function readUser($where = array()){
        $datas = array();
        $userModels = UserModel::getAllUser($where);
        foreach ($userModels as $userModel){
            $tmp = array();
            $tmp['id'] = $userModel->id;
            $tmp['username'] = $userModel->username;
            $tmp['name'] = $userModel->name;
            $tmp['phone'] = $userModel->phone;
            $tmp['email'] = $userModel->email;
            $tmp['type'] = $userModel->type;
            $tmp['update_time'] = $userModel->update_time;
            array_push($datas, $tmp);
        }
        return $datas;
    }

    // 用户查询
    public function searchUser(){
        $params = input();
        $where = array();
        if (!empty($params['username'])){
            $where['username'] = trim($params['username']);
        }
        if (!empty($params['name'])){
            $where['name'] = trim($params['name']);
        }
        if (!empty($params['phone'])){
            $where['phone'] = trim($params['phone']);
        }
        if (!empty($params['type'])){
            $where['type'] = trim($params['type']);
        }
        $users = $this->readUser($where);
        $this->assign('userNumbers', count($users));
        $this->assign('users', $users);
        return $this->fetch();
    }

    // 停用用户,将用户的status改为0
    public function closeUser(){
        $id = input('userid');
        $userModel = UserModel::get($id);
        if (!empty($userModel)){
            $userModel->status = 0;
            if ($userModel->save()){
                $res['code'] = 200;
                $res['message'] = '停用成功';
                return json($res);
            }
        }
        $res['code'] = 500;
        $res['message'] = '停用失败';
        return json($res);
    }

    // 修改用户信息
    public function editUser(){
        $id = input('userid');
        $data = array();
        if (!empty(input('name'))){
            $data['name'] = input('name');
        }
        if (!empty(input('type'))){
            $data['type'] = input('type');
        }
        if (!empty(input('phone'))){
            $data['phone'] = input('phone');
        }
        if (!empty(input('email'))){
            $data['email'] = input('email');
        }
        $userModel = UserModel::get($id);
        if (!empty($userModel)){
            // 修改成功
            if ($userModel->save($data)){
                $res['code'] = 200;
                $res['message'] = '修改用户信息成功';
                return json($res);
            }
        }
        // 失败
        $res['code'] = 500;
        $res['message'] = '修改用户信息失败';
        return json($res);
    }
}