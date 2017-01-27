<?php
/**
 * Created by PhpStorm.
 * User: LuSonghua
 * Date: 2017/1/26
 * Time: 18:05
 */

namespace app\common\libs;


class MyCurl {
    protected $_useragent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36';
    protected $_url;
    protected $_followlocation;
    protected $_timeout;
    protected $_maxRedirects;
    protected $_cookieFileLocation = './cookie.txt';
    protected $_post;
    protected $_postFields;
    protected $_referer ="http://www.midnightvip.com";

    protected $_session;
    protected $_webpage;
    protected $_includeHeader;
    protected $_noBody;
    protected $_status;
    protected $_binaryTransfer;
    public    $authentication = 0;
    public    $auth_name      = '';
    public    $auth_pass      = '';
    // 自己添加的参数
    protected $_infoMsg;// 响应头信息
    protected $_headers;// 设置请求头
    protected $_params; // 请求参数
    public    $method = 'GET'; //请求方法

    public function setHeaders($headers){
        if (!empty($headers)){
            $this->_headers = $headers;
        }
        $this->_headers = array();
    }

    public function setParams($params){
        if (!empty($params)){
            $this->_params = http_build_query($params);
        }else{
            $this->_params = array();
        }
    }

    public function useAuth($use){
        $this->authentication = 0;
        if($use == true) $this->authentication = 1;
    }

    public function setName($name){
        $this->auth_name = $name;
    }
    public function setPass($pass){
        $this->auth_pass = $pass;
    }

    public function __construct($url,$followlocation = true,$timeOut = 30,$maxRedirecs = 4,$binaryTransfer = false,$includeHeader = false,$noBody = false)
    {
        $this->_url = $url;
        $this->_followlocation = $followlocation;
        $this->_timeout = $timeOut;
        $this->_maxRedirects = $maxRedirecs;
        $this->_noBody = $noBody;
        $this->_includeHeader = $includeHeader;
        $this->_binaryTransfer = $binaryTransfer;

        $this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';

    }

    public function setReferer($referer){
        $this->_referer = $referer;
    }

    public function setCookiFileLocation($path)
    {
        $this->_cookieFileLocation = $path;
    }

    public function setPost ($postFields)
    {
        $this->_post = true;
        $this->_postFields = $postFields;
    }

    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
    }

    public function createCurl()
    {
        if($this->method == 'GET'){
            if (!empty($this->_params)){
                $this->_url .= "?$this->_params";
            }
        }
        $s = curl_init();
        curl_setopt($s,CURLOPT_URL,$this->_url);
        curl_setopt($s,CURLOPT_HTTPHEADER,$this->_headers);
        curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
        curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
        curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
        curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
        curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);

      if($this->authentication == 1){
          curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
      }
      if($this->_post)
      {
          curl_setopt($s,CURLOPT_POST,true);
          curl_setopt($s,CURLOPT_POSTFIELDS,$this->_params);

      }

      if($this->_includeHeader)
      {
          curl_setopt($s,CURLOPT_HEADER,true);
      }

      if($this->_noBody)
      {
          curl_setopt($s,CURLOPT_NOBODY,true);
      }
      /*
      if($this->_binary)
      {
          curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
      }
      */
      curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
      curl_setopt($s,CURLOPT_REFERER,$this->_referer);
      // 显示请求头
      curl_setopt($s, CURLINFO_HEADER_OUT, true);

      $this->_webpage = curl_exec($s);
      $this->_infoMsg =curl_getinfo($s);
      $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
      curl_close($s);

    }

    public function getHttpStatus()
    {
      return $this->_status;
    }

    public function __tostring(){
      return $this->_webpage;
    }

    public function getResponseContent(){
      return $this->_webpage;
    }

    // 获取响应的相关信息
    public function getInfoHeader(){
      return $this->_infoMsg;
    }
    }
