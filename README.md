介绍
==========

ThinkPHP 集成 [Whoops](https://github.com/filp/whoops)

安装使用
------

```
composer require snowair/think-whoops:dev-master
```

就是这么简单, whoops立即生效了!


* 当 `APP_DEBUG=false;` 时就会自动禁用 whoops 以保证安全.

* 如果需要强制启用whoops(为了安全不建议这样做), 只需在 index.php 添加一项配置:`"WHOOPS"=>true;`

