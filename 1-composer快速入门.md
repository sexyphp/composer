#Composer快速入门

### 一.认识Composer

Composer作为近几年新兴的组件式开发最为现代化进程的一个标志,下面引用[岁寒]博主对Composer的精彩介绍我想再适合不过了,感觉官方对Composer的优点介绍还没有岁寒大神的文章精彩啊!

Composer 一统天下的时代已经到来！

Framework Interoperability Group（框架可互用性小组），简称 FIG，成立于 2009 年。FIG 最初由几位知名 PHP 框架开发者发起，在吸纳了许多优秀的大脑和强健的体魄后，提出了 PSR-0 到 PSR-4 五套 PHP 非官方规范：

1. PSR-0 (Autoloading Standard) 自动加载标准

2. PSR-1 (Basic Coding Standard) 基础编码标准

3. PSR-2 (Coding Style Guide) 编码风格向导

4. PSR-3 (Logger Interface) 日志接口

5. PSR-4 (Improved Autoloading) 自动加载优化标准



之后，在此标准之上，Composer 横空出世！Composer 利用 PSR-0 和 PSR-4 以及 PHP5.3 的命名空间构造了一个繁荣的 PHP 生态系统。Composer 类似著名的 npm 和 RubyGems，给海量 PHP 包提供了一个异常方便的协作通道，Composer Hub 地址：https://packagist.org  Composer 中文网站：http://www.phpcomposer.com

目前 PHP 界风头正劲的 Laravel 和 Symfony 均直接基于 Composer，大家耳熟能详著名框架 CI 和 Yii 的正开发版本 CodeIgniter 3 和 Yii 2 也都基于 Composer（更新：北京时间2014年10月13日 Yii 2 已经发布）。Composer 就是 PHP 框架的未来，有了它，让 CI 的路由和 Laravel 的 Eloquent ORM 协作就会变的非常简单。


### 二.快速安装

命令行下载需要先进入到指定项目根目录,无则创建!网页下载完毕后直接粘贴到项目根目录即可.

#####1.下载和安装

(1).`最简单最快最粗暴的方法:` 直接下载与本文章同目录的 composer.phar即可 

(2).使用PHP命令下载: 
    
        #php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
        
        #php composer-setup.php
       
(3).使用CURL命令下载:
    
        #curl -sS https://getcomposer.org/installer | php
        
(4).到官方网址点击选中版本下载或者哪里有composer.phar,直接下载该文件就行官网下载地址链接:
       
       https://getcomposer.org/download/


#####2.检验安装是否成功
执行下面命令测试是否安装成功,成功则输出帮助命令,不成功则出现红色提示

    #php composer.phar
   


#####3.局部和全局使用

局部使用就是需要带上php命令执行,只能在该根目录下操作,全局则对整个系统有效

(1)局部操作,使用局部操作则无需多做其他操作了,直接使用 
    
   #php composer.phar [命令参数]
   
(2)全局操作全局操作,就是把composer.phar移到系统PATH环境中,如Unix系统下执行以下命令:

    #mv composer.phar /usr/local/bin/composer
   
然后在系统的任何地方执行composer命令查看是否有什么惊喜吗?


Windows用户请自行研究PATH环境变量怎么使用吧!
   
   
   
### 三.Composer.json快速实践

Composer说得通俗一点就相当于组件式开发,只要符合psr-4规范的组件,类库,函数库,文件等都可以使用Composer.Composer可以小到只为你自动加载一个小小的配置文件,大到可以为你构建自己的框架,构建分布式应用.当你学会了自然会爱不释手的,比如参考岁寒的文章构建一次自己的小框架试试,相信会让你更喜欢Composer的.

#####1.安装或更新所有依赖

    php composer.phar update 或 composer update 
     
#####2.安装或更新一个依赖 

    php composer.phar update monolog/monolog […]  
    
#####3.自动加载库文件，必须在入口中或你想更方便的加载第三方代码
    
    require 'vendor/autoload.php’;   
  
#####4.使用composer头描述: 标明该项目名，描述信息，关键字，类型,版权声明，作者,开发版本类型

    {
        "name": "test/composer",
        "description": "This is a simple test for use composer",
        "keywords": ["library", "Framework"],
        "type": "project",
        "license": "Apache2",
        "authors": [
            {
                "name": "liangfeng",
                "email": "1092313007@qq.com"
            }
        ],
        "minimum-stability": "beta",
        "require": {}
    }

#####5.引入依赖包链接(Package links)
可在https://packagist.org 搜索开源的各种类型的包,如phpunit,phpdoc,monolog,orm等等第三方提供的强大组件,可想而知composer多么的强大.

引入包的格式都应该是: 

    { 
        "引入方式" {
            "供应商/包名" : "版本"  
        }
    }
    

引入依赖有5种方式,常用有2种[require],[require-dev (root-only)],不常用有3种 [conflict],[replace],[provide]

1)require 必须的软件包列表，除非这些依赖被满足，否则不会完成安装。

    {
      "require": {
          "monolog/monolog": "1.0.*"
      }
    }

2)require-dev(root-only) 这个列表是为开发或测试等目的，额外列出的依赖。“root 包”的 require-dev 默认是会被安装的。然而 install 或 update 支持使用 --no-dev 参数来跳过 require-dev 字段中列出的包。
  
    {
        "require-dev": {
            "monolog/monolog": "1.0.*"
        }
    }
                      
其他不常用的就不讲了,那三个包分别是:

conflict(此列表中的包与当前包的这个版本冲突)

replace(列表中的包将被当前包取代)

provide(此包提供的其他包的列表,这主要是有用的常见的接口)

引入依赖包需要熟悉require和require-dev外,其中版本是一个需要特别熟悉的地方,入面引入官方详细说明

#####6.composer.json文件之autoload
使用autoload可加载本地所需要的自动加载文件。对于第三方包的自动加载，Composer提供了四种方式的支持,分别是psr-0  psr-4  classmap  和 files。

   ( 1 ) `ClassMap`  是通过配置指定的目录或文件,执行安装或更新时,它会扫描指定目录下以.php或.inc结尾的文件中的class，生成class到指定file path的映射，并加入新生成的 vendor/composer/autoload_classmap.php 文件中
   
   ( 2 ) `PSR-4`是composer推荐使用的一种方式，因为它更易使用并能带来更简洁的目录结构。按照PSR-4的规则，当试图自动加载"App\\Bar\\Baz"这个class时，会去寻找”app/Bar/Baz.php"这个文件，如果它存在则进行加载。注意，”App\\"并没有出现在文件路径中

   ( 3 ) `PSR-0`  与PSR-4不同的一点，如果PSR-0有此配置，那么会去寻找”app/App/Bar/Baz.php"这个文件。

   ( 4 ) `Files`  就是手动指定供直接加载的文件。比如说我们有一系列全局的helper functions，可以放到一个helper文件里然后直接进行加载
    
    "autoload": {
        "classmap": [
            "vendor/sexyphp"
        ],
        "psr-4": {
            "App\\": "app/“          //key(namespace)和value(相应path)定义方式,  App\\ 双反斜杠前者是转义符
        }，
       “psr-0": [
            "App\\": “app/“
        ],
      "files": [
        "src/MyLibrary/functions.php”
      ]  
    },


#####7.以 laravel 项目的 composer.json 配置文件为例:

    {
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": ">=5.6.4",
        "laravel/framework": "5.3.*"
    },
    "require-dev": {
        "fzaninotto/faker": "~1.4",
        "mockery/mockery": "0.9.*",
        "phpunit/phpunit": "~5.0",
        "symfony/css-selector": "3.1.*",
        "symfony/dom-crawler": "3.1.*"
    },
    "autoload": {
        "classmap": [
            "database",
            "vendor/sexyphp"
        ],
        "psr-4": {
            "App\\": "app/"
        }
    },
    "autoload-dev": {
        "classmap": [
            "tests/TestCase.php"
        ]
    },
    "scripts": {
        "post-root-package-install": [
            "php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "php artisan key:generate"
        ],
        "post-install-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postInstall",
            "php artisan optimize"
        ],
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate",
            "php artisan optimize"
        ]
    },
    "config": {
        "preferred-install": "dist"
    }
    }

关于学完快速入门后,是否对Composer有一定的了解啦，或许你还没我那么喜爱它吧，因为它还有很多强大的功能在上面我们还没有应用到它，下一篇文章将介绍如何编写符合Composer自动加载的组件／类库，慢慢我们接触包括script执行脚本，构建自己的CLI命令帝国，利用Composer构建自己的框架帝国，再用Composer上传自己的开源作品，只要到开源作品的展示并受大家欢迎，你已经可以问鼎PHP(拼音)的制品人啦！
