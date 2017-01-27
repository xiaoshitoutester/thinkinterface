<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/25
 * Time: 8:58
 */

namespace app\index\controller;
use app\common\model\Testcase as TestcasModel;
use app\common\libs\MyCurl;
use app\common\libs\MyRequsts;

// 用例管理
class CaseManage extends Index
{
    public function index(){
        return $this->fetch();
    }

    //测试curl
    public function getMyCurl(){
        $url = 'http://www.thinkinterface.com/index.php/index/login/test';
        $myCurl = new MyRequsts($url,'POST');
        $myCurl->setHeaders(array('Content-type:application/json; charset=utf-8','test:1223'));
        $myCurl->setParams(array('name'=>'admin','pwd'=>'123456'));
        $myCurl->createCurl();
        $res['responseResult'] = $myCurl->getResponseContent();
        $res['requestHeader'] = $myCurl->getResponseHeaders()['request_header'];
        $res['responseHeader'] = $this->arrToString($myCurl->getResponseHeaders());
//        dump($myCurl->getInfoHeader());
        return json($res);
    }

    // 将数组转化成字符串
    public function arrToString($arr)
    {
        $str = '';
        foreach ($arr as $key => $val) {
            if ($key == 'request_header'){
                continue;
            }
            if (is_string($val)) {
                $str .= "$key:$val\r\n";
            }else if(is_float($val) || is_int($val)){
                $str .= "$key:".(string)$val."\r\n";
            }
        }
        return $str;
    }
}