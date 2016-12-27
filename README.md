# Composer命令中文手册
 本手册只提供基于Unix系统所操作的命令,适用于类似MAC OS,Centos,Ubuntu等系统,手册将详细介绍和提供composer命令集成中文手册，与Composer中文社区不冲突，这犹如官方文档和我们提供的实用命令锦集搭配会使你更熟悉Composer，并可以快速实用Composer

#### 依赖管理
Composer 不是一个包管理器。是的，它涉及 "packages" 和 "libraries"，但它在每个项目的基础上进行管理，在你项目的某个目录中（例如 vendor）进行安装。默认情况下它不会在全局安装任何东西。因此，这仅仅是一个依赖管理。

这种想法并不新鲜，Composer 受到了 node's npm 和 ruby's bundler 的强烈启发。而当时 PHP 下并没有类似的工具。

Composer 将这样为你解决问题：

a) 你有一个项目依赖于若干个库。

b) 其中一些库依赖于其他库。

c) 你声明你所依赖的东西。

d) Composer 会找出哪个版本的包需要安装，并安装它们（将它们下载到你的项目中）。


#### 声明依赖关系

比方说，你正在创建一个项目，你需要一个库来做日志记录。你决定使用 monolog。为了将它添加到你的项目中，你所需要做的就是创建一个 composer.json 文件，其中描述了项目的依赖关系。
```
{
    "require": {
        "monolog/monolog": "1.2.*"
    }
}
```
我们只要指出我们的项目需要一些 monolog/monolog 的包，从 1.2 开始的任何版本。