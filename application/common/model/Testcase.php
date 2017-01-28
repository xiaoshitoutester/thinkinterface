<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/25
 * Time: 19:33
 */

namespace app\common\model;


use think\Model;

class Testcase extends Model
{
    // 修改器
    protected function setContenttypeAttr($value){
        $data = [
            '1' => 'application/x-www-form-urlencoded',
            '2' => 'multipart/form-data',
            '3' => 'application/json',
            '4' => 'text/xml'
        ];
        return $data[$value];
    }

}