<?php

require "vendor/autoload.php";

$api    =   new \Sexyphp\Src\Api('http://sexyphp.com/');

$data   =   $api->getData('index.php?m=Home&c=Article&a=index&id=4');

var_dump($data);
