<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/25
 * Time: 8:58
 */

namespace app\index\controller;
use app\common\model\Testcase as TestcasModel;
use app\common\libs\MyRequsts;

// 用例管理
class CaseManage extends Index
{
    public function index(){
        return $this->fetch();
    }

    // 执行测试用例
    public function getMyCurl(){
        $url = 'http://www.thinkinterface.com/index.php/index/login/test';
        $myCurl = new MyRequsts($url,'GET');
        $myCurl->setHeaders(array());
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

    // 添加测试用例
    public function addTestCase(){
//        $params['url'] = input('url');
//        $params['method'] = input('method');
//        $params['contenttype'] = input('contenttype');
//        if (!empty(input('headers'))){
//            $params['headers'] = $this->stringToArr(input('headers'));
//        }
//        if (!empty(input('params'))){
//            $params['params'] = $this->stringToArr(input('params'));
//        }
//
//        return dump($params);
        $params['caseName'] = input('caseName');
        $params['url'] = input('url');
        $params['method'] = input('method');
        $params['contenttype'] = input('contenttype');
        $params['headers'] = input('headers');
        $params['params'] = input('params');
        $params['level'] = input('level');
        $testcaseModel =  new TestcasModel();
        $testcaseModel->name = $params['caseName'];
        $testcaseModel->url = $params['url'];
        $testcaseModel->method = $params['method'];
        $testcaseModel->contenttype = $params['contenttype'];
        $testcaseModel->headers = $params['headers'];
        $testcaseModel->params = $params['params'];
        $testcaseModel->level = $params['level'];
        if ($testcaseModel->save()){
            $res['code'] = 200;
            $res['message'] = '新增用例成功';
            return json($res);
        }
        $res['code'] = 500;
        $res['message'] = '新增用例失败';
        return json($res);
    }

    // 将字符串转化成数组
    protected function stringToArr($str){
        $res = array();
        $str = str_replace('"','',$str);
        $str = str_replace('\'','',$str);
        $str = str_replace('{','',$str);
        $str = str_replace('}','',$str);
        $tmp_arr = explode(';',$str);
        foreach ($tmp_arr as $val){
            $tmp = explode(':',$val);
            $res[$tmp[0]] = $tmp[1];
        }
        return $res;
    }
}