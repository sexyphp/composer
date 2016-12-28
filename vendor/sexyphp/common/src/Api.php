<?php namespace Sexyphp\Src;
use Sexyphp\Src\Curl;

class Api
{

    private $curl;
    private $pathSuffix;

    /**
     * Api constructor.
     */
    public function __construct($pathSuffix)
    {
        $this->curl = new Curl();
        $this->pathSuffix = $pathSuffix;
    }

    public function getData($uri)
    {
        $out = $this->curl->get($this->pathSuffix.$uri);

        if ($this->curl->http_code != 200) {
            throw new \Exception("error: can't connect server");
        }
        if(is_null(json_decode($out))){
            if(env('APP_DEBUG')){
                var_dump($out);
            }
            throw new \Exception('error: is not json');
        }

        $json = $this->str2json($out);

        if ( !isset($json["code"])) {
            if(env('APP_DEBUG')){
                echo $out;
            }
            throw new \Exception('error:not find json[code]');

        }

        return $out;
    }

    public function postData($uri, $vars = array())
    {
        $out = $this->curl->post($this->pathSuffix.$uri, $vars);
        $json = $this->str2json($out);
        if ($json["code"] == 200) {
            return $json["data"];
        } else {
            throw new \Exception($json["msg"]);
        }
    }

    private function str2json($str)
    {
        return json_decode($str,true);
    }
}



