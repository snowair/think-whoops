介绍
==========

ThinkPHP 集成 [Whoops](https://github.com/filp/whoops)

安装使用
------

```
composer require snowair/think-whoops:dev-master
```

然后在项目的 `Common/Conf/config.php` 文件的前面加一行:`whoops();`来注册Whoops.

例如:

```
whoops();
return array(
    ...
);
```

* 实际上 `whoops()` 注册函数可以放在几乎任何`app_init`之后的任何地方.

禁用whoops
--------

* composer 的 autoload.php 文件必须在index.php中的**所有常量**定义之后被 include, 否则whoops无法被禁用.

* 当 `APP_DEBUG=false;` 时, whoops就会自动禁用以保证安全.

* 如果需要强制启用whoops(为了安全不建议这样做), 只需在 index.php 添加一个常量`WHOOPS=true;`

