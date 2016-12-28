##Composer构建自己的Composer包

简介:你或许使用过多个框架，或许自己开发过很多组件，多个类库，接口等。会不会因为切换框架而头疼，是不是还得修改你的代码，可能还得在某一框架里面重新包含这些文件进来。现在有两个工具可以帮助你解决这一问题,它们分别是Composer和PEAR.我们主要推荐Composer,并使用Composer开发基于psr系列规范化的组件，类库等。可以达到一次编程，随处可用的效果。当然，这是得注意一下PHP版本。下面我们将一一领略使用Composer创建自己的组件，并在Thinphp和Laravel中使用来证明为何说Composer一统PHP天下的时代来临。

#####要点:
理解composer如何实现自动加载第三方组件;
理解psr-0和psr-4的规范;
理解基于psr-0,psr-4,classmap,files如何实现自动加载。
理解Composer和Packagist


如:要编写一个Api类,该类主要是使用CURL模拟HTTP的GET和POST请求.

#####1.先创建目录结构:

    $ mkdir -p  sexyphp/curl-http-request/src/
  

如: sexyphp/curl-http-request/src/  

#####2.创建文件

    $touch sexyphp/curl-http-request/src/Api.php 
    
#####3.写入文件内容:
  
    格式如:
        namespace DIRNAME\...\DIRNAME;
        Use  DIRNAME\...\DIRNAME\FILENAME;
        
        const CONNECT_OK = 1;
        class Connection { /* ... */ }
        function connect() { /* ... */  }
       
    内容:
    
        <?php 
        namespace Sexyphp\Src;
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

还有一个CURL类的代码没贴出来,详情可在GITHUB中查看项目源码:https://github.com/sexyphp/composer/tree/master/vendor/sexyphp
是否跟你所的类库也很相似,这都是得益于PHP5.3之后的命名空间的出现.命名空间不熟悉的话,请先看看官方的介绍:http://php.net/language.namespaces.

#####4.通过上面的操作,已经完成该了两个类库的开发,那么如何使用Composer来实现依赖关系呢!聪明的你,应该想到了需要创建一个composer.json文件了.

1) composer包的目录结构
你现在可以看看Laravel或者Thinphp包含有vendor目录下面的组件,仔细看看都有什么规律吗?咱们以laravel框架下的vendor/laravel为例,当然其他框架的也可以看看,大致都是一样的规律,这就是统一规范的好处!那就是不让你随便定义组件文件和代码结构,你有你的style,我有我的style,那就叫花式虐狗了.

    example for laravel/laravel:
        laravel
            framework
                src
                ...
                ...
                    dirname../**.[class].php
                
                composer.json
                LICENCE.md
                README.md
                        
一个供应商可能还有N个开源工具在同一个包里面,上面是一个常见的结构,还有一种如下:

    example for laravel/phpunit:
        phpunit
            php-code-coverage
                src
                ...
                ...
                    dirname../**.[class].php
                
                composer.json
                LICENCE.md
                README.md
                
            php-timer
                src
                ...
                ...
                    dirname../**.[class].php
                
                composer.json
                LICENCE.md
                README.md
                
其实我个人也只推荐这两种,虽然说基于命名空间你可随处都放,只要自动加载能找到就行.所以标准就是要大家规范化编程,养成良好的撸代码习惯,太骚气的代码容易惹祸上身哦!
       
2).创建composer.json实现自动加载所需依赖组件,简单的组件json格式如下:

    {
        "name": "sexyphp/curl-http-request",
        "description": "The Sexyphp curl-http-request.",
        "keywords": ["sexyphp", "curl","http request"],
        "type": "library",
        "license": "MIT",
        "homepage": "http://sexyphp.com",
        "support": {
            "issues": "https://github.com/sexyphp/composer/issues",
            "source": "https://github.com/sexyphp/composer/tree/master/vendor/sexyphp"
        },
        "authors": [
            {
                "name": "LiangFeng",
                "email": "1092313007@qq.com"
            }
        ],
        "require": {
            "php":                               "^5.3|^7.0"
        },
        "replace": {
        },
        "require-dev": {
    
        },
        "autoload": {
            "classmap": [
                "src/"
            ]
        },
        "extra": {
            "branch-alias": {
                "dev-master": "1.0-dev"
            }
        }
    }


#####5.在应用目录外的composer.json加入(只选一种):

    "autoload-dev": {
        "classmap": [
            "vendor/sexyphp"
        ]
    },
    
    或者:
    
    "autoload": {
        "classmap": [
            "vendor/sexyphp"
        ]
    },
    
    或者:
    
    "autoload":{
        "psr-4": {
            "Sexyphp\\" : "vendor/sexyphp/curl-http-request"
        }
    },
        

可根据上一篇博客所说的使用4种加载方式,`classmap,psr-0,psr-4,files`

#####6.执行dump-autoload加载

    $ composer dump-autoload
    
#####7.如果报错,可能是json文件的格式没对.如果没报错,那就查看vendor/composer/autoload_classmap.php或autoload_static.php是否自动加载了你自己开发的包.

    eg: autoload_classmap.php
    
        'Sexyphp\\Src\\Api' => $vendorDir . '/sexyphp/curl-http-request/src/Api.php',
        'Sexyphp\\Src\\Curl' => $vendorDir . '/sexyphp/curl-http-request/src/Curl.php',

    eg: autoload_static.php
    
        'Sexyphp\\Src\\Api' => __DIR__ . '/..' . '/sexyphp/curl-http-request/src/Api.php',
        'Sexyphp\\Src\\Curl' => __DIR__ . '/..' . '/sexyphp/curl-http-request/src/Curl.php',
        

#####8.在入口目录中调用Api类查看是否正确加载进来了.

    <?php
    
    require "vendor/autoload.php";
    
    $api    =   new \Sexyphp\Src\Api('http://sexyphp.com/');
    
    $data   =   $api->getData('index.php?m=Home&c=Article&a=index&id=4');
    
    var_dump($data);
    
```shell
    $ php index.php查看var_dump输出 或浏览器输入 : localhost查看

``` 

本篇就将到这里,下一篇将使用Composer创建抽象接口集成组件式开发.

本篇文章同步项目源码地址:https://github.com/sexyphp/composer 

#####问题:你理解composer如何实现自动加载第三方组件了吗?