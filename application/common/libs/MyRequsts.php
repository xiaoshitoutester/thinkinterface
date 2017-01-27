<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/27
 * Time: 20:20
 */

namespace app\common\libs;


class MyRequsts
{
    protected $_useragent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36';
    protected $_url;
    protected $_timeout; // 超时时间
    protected $_followlocation; // 自动重定向
    protected $_maxRedirects; // 自动重定向的最大次数
    protected $_referer ="http://www.baidu.com";
    protected $_headers;// 设置请求头
    protected $_params; // 请求参数
    protected $_method; //请求方法
    protected $_responsecontent; // 响应的内容
    protected $_responseheaders;// 响应头信息
    protected $_responsestatus; // 响应状态

    // 设置请求头:array('Content-type: text/plain', 'Content-length: 100')
    public function setHeaders($headers){
        if (!empty($headers)){
            $this->_headers = $headers;
        }else{
            $this->_headers = array();
        }
    }
    // 设置请求参数
    public function setParams($params){
        if (!empty($params)){
            $this->_params = http_build_query($params);
        }else{
            $this->_params = array();
        }
    }

    public function __construct($url, $method='GET', $followlocation = true, $timeOut = 30, $maxRedirecs = 4)
    {
        $this->_url = $url;
        $this->_method = $method;
        $this->_followlocation = $followlocation;
        $this->_timeout = $timeOut;
        $this->_maxRedirects = $maxRedirecs;
    }

    public function setReferer($referer){
        $this->_referer = $referer;
    }

    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
    }

    public function createCurl()
    {
        if($this->_method == 'GET'){
            if (!empty($this->_params)){
                $this->_url .= "?$this->_params";
            }
        }
        $s = curl_init();
        curl_setopt($s,CURLOPT_URL,$this->_url);
        curl_setopt($s,CURLOPT_HTTPHEADER,$this->_headers);
        curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
        curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
        curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
        // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
        if($this->_method == 'POST')
        {
            curl_setopt($s,CURLOPT_POST,true);
            curl_setopt($s,CURLOPT_POSTFIELDS,$this->_params);

        }
        curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
        curl_setopt($s,CURLOPT_REFERER,$this->_referer);
        // 启用时追踪句柄的请求字符串。
        curl_setopt($s, CURLINFO_HEADER_OUT, true);

        $this->_responsecontent = curl_exec($s);
        $this->_responseheaders =curl_getinfo($s);
        $this->_responsestatus = curl_getinfo($s,CURLINFO_HTTP_CODE);
        curl_close($s);
    }

    public function getHttpStatus()
    {
        return $this->_responsestatus;
    }

    public function getResponseContent(){
        return $this->_responsecontent;
    }

    // 获取响应的相关信息
    public function getResponseHeaders(){
        return $this->_responseheaders;
    }
}