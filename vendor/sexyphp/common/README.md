[TOC]

#分布式平台

## 服务及接口

|服务名称|host地址|占用端口|描述|
|-|-|-|-|
|AutoIDServer|auto.id.host|20100|自增ID生成器|
|UserServer|user.server.host|20200|用户服务|
|ShopServer|shop.server.host|20300|商品服务|
|展销前段|...|8080|..|

## 新建一个服务

全局镜像使用：
```shell
composer config -g repo.packagist composer http://packagist.phpcomposer.com
```

```shell
composer global require "laravel/lumen-installer=~1.0"
```

```shell
$
$ mkdir TestServer/api
$ cd TestServer
$ composer create-project --prefer-dist laravel/lumen server
$ cd ../api
$ composer init --name="shinc/shop-server-api" --type=project -n
$ 
```

## 运行一个服务
1、需要update项目依赖

```shell
cd XXXXServer/server
composer update
```

2、运行（简易方式）

```shell
cd public 
php -S <host>:<port>
```

## 开发Git规范
+ branch 分支规范：

  > master ：主分支，线上部署代码
  > test   : 进入测试代码，只有开发完成了才允许合并到此分支
  > dev    : 开发分支，处于开发阶段分支
  > XXXXXX : 正处于开发的分支，此分支不需提交git
  
+ Tags 标签规范

  > 不允许提交本地标签
  > 线上版本标签 格式 vN.n.n.yyyyMMddHHmm 例如：v1.0.0.201601201501

+ 代码编写提交规范

  > 更新所有分支
  > 从dev 分支穿件一个新的开发分支
  > 在新的分支进行开发，
  > 开发完成，更新dev分支，合并当前分支到dev分支，测试无误项目组长将dev合并到test
  > 测试拉取test进行测试
   