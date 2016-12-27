# composer.json 快速操作
1.安装或更新所有依赖

    php composer.phar update 或 composer update 
     
2.安装或更新一个依赖 

    php composer.phar update monolog/monolog […]  
    
3.自动加载库文件，必须在入口中或你想更方便的加载第三方代码
    
    require 'vendor/autoload.php’;   
  
4.使用composer头描述: 标明该项目名，描述信息，关键字，版权声明，项目类型，作者

    "name": "sexyphp/vendor",
    "description": "The vendor library from sexyphp.",
    "keywords": ["library", "Framework"],
    "license": "Apache2",
    "type": "project",
    "authors": [
        {
            "name": "liangfeng",
            "email": "109231300&@qq.com"
        }
    ],

5.composer.json文件之require ,使用require可以安装或者更新你所需要依赖的包。大括号里面则表示需要载入的包名称和当前包的版本信息
   
    {
        "require": {
            "monolog/monolog": "1.0.*"
        }
    }


6.composer.json文件之autoload，使用autoload可加载本地所需要的自动加载文件。对于第三方包的自动加载，Composer提供了四种方式的支持,分别是psr-0  psr-4  classmap  和 files。

   ( 1 ) ClassMap  是通过配置指定的目录或文件,执行安装或更新时,它会扫描指定目录下以.php或.inc结尾的文件中的class，生成class到指定file path的映射，并加入新生成的 vendor/composer/autoload_classmap.php 文件中
   
   ( 2 ) PSR-4是composer推荐使用的一种方式，因为它更易使用并能带来更简洁的目录结构。按照PSR-4的规则，当试图自动加载"App\\Bar\\Baz"这个class时，会去寻找”app/Bar/Baz.php"这个文件，如果它存在则进行加载。注意，”App\\"并没有出现在文件路径中

   ( 3 ) PSR-0  与PSR-4不同的一点，如果PSR-0有此配置，那么会去寻找”app/App/Bar/Baz.php"这个文件。

   ( 4 ) Files  就是手动指定供直接加载的文件。比如说我们有一系列全局的helper functions，可以放到一个helper文件里然后直接进行加载
    
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

