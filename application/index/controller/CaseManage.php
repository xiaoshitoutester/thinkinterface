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

// 用例管理
class CaseManage extends Index
{
    public function index(){
        return $this->fetch();
    }
    public function test(){
        $testCase = TestcasModel::get(1);
        $url = $testCase->url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $res = json_decode(curl_exec($ch));
        $head = curl_getinfo($ch);
        curl_close($ch);
        return dump($res);
    }
    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
    function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }

    //测试curl
    public function getMyCurl(){
        $url = 'http://www.thinkinterface.com/index.php/index/login/test';
        $myCurl = new MyCurl($url);
        $myCurl->createCurl();
//        dump($myCurl->getHttpStatus());
//        dump($myCurl->getResponseContent());
        $res['responseResult'] = $myCurl->getResponseContent();
        $res['requestHeader'] = $myCurl->getInfoHeader()['request_header'];
        $res['responseHeader'] = $myCurl->getInfoHeader();
        return json($res);
    }

    // 将数组转化成字符串
    public function arrToString($arr){
        $str = '';
        foreach ($arr as $key=>$val){
            $str = $str."$key:$val;";
        }
        return $str;
    }
}