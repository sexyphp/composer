<?php namespace Sexyphp\Src;
/**
 * CURL wrapper class
 * @author: KevinChen
 */
class Curl{
    var $callback,$user_agent,$cookie,$proxy,$timeout,$http_code;

    public function __construct(){
        $this->callback = false;
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        }else{
            $this->user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0';
        }

        $this->cookie = false;
        $this->proxy = '';
        $this->timeout = 10;
    }

    function setCallback($func_name) {
        $this->callback = $func_name;
    }
    function setUserAgent($agent) {
        $this->user_agent = $agent;
    }
    function setCookie($cookie){
        $this->cookie = $cookie;
    }
    //add for proxy by liangbo 2012.8.2
    function setProxy($proxy) {
        $this->proxy = $proxy;
    }
    function setTimeout($num){
        $this->timeout = $num;
        return $this;
    }


    function doHeadInfo($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, 1); // important! set this option is using the "header method"
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,$this->user_agent);
        //curl_setopt($ch, CURLOPT_REFERER,$url);
        curl_setopt($ch, CURLOPT_ENCODING,"gzip");
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //add for proxy by liangbo 2012.8.2
        if($this->proxy != "") {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }

        $data = curl_exec($ch);

        if(empty($data)){
//			$err = curl_error($ch);
            $err = false;
            curl_close($ch);
            return $err;
        }else{
            $info = curl_getinfo($ch);
            curl_close($ch);
            return $info;
        }
    }

    function doRequest($method, $url, $vars, $referer = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,$this->user_agent);
        curl_setopt($ch, CURLOPT_ENCODING,"gzip");
        curl_setopt($ch, CURLOPT_TIMEOUT,30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($this->cookie != false){
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        }

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        }
        if (!empty($referer)) {
            curl_setopt($ch, CURLOPT_REFERER , $referer);
        }
        //add for proxy by liangbo 2012.8.2
        if($this->proxy != "") {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }

        $data = curl_exec($ch);

        if ($data) {
            /**
             *  因为历史的原因，这里hack一下~~
             * 分析curl返回的结果
             */
            $result = array();
            $header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
            $result['header'] = $this->pass_header( substr($data, 0, $header_size) );
            $result['body'] = substr( $data , $header_size );
            $result['http_code'] = curl_getinfo($ch , CURLINFO_HTTP_CODE);
            $result['last_url'] = curl_getinfo($ch , CURLINFO_EFFECTIVE_URL);
            $result['last_sent']=curl_getinfo($ch ,CURLINFO_HEADER_OUT );

            //$data = $result;
            $data = $result['body'];

            $this->http_code = $result['http_code'];

            if ($this->callback)
            {
                $callback = $this->callback;
                $this->callback = false;
                return call_user_func($callback, $data);
            } else {
                curl_close($ch);
                return $data;
            }
        } else {
            curl_close($ch);
            return false;
        }
    }
    public function pass_header($header)
    {
        $result=array();
        $varHader=explode("\r\n", $header);
        if(count($varHader)>0)
        {
            for($i=0;$i<count($varHader);$i++)
            {
                $varresult=explode(":",$varHader[$i]);
                if(is_array($varresult) && isset($varresult[1]))
                    $result[$varresult[0]]=$varresult[1];
            }
        }
        return $result;
    }
    function head($url){
        return $this->doHeadInfo($url);
    }

    function get($url, $referer = '') {
        $checkPos = strpos ( $url , "#");
        if ( $checkPos !== false ) {
            $url = substr ( $url , 0 , $checkPos );
        }
        return $this->doRequest('GET', $url, 'NULL', $referer);
    }

    function post($url, $vars) {
        return $this->doRequest('POST', $url, $vars);
    }
}