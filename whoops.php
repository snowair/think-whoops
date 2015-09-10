<?php

namespace Snowair;

use Think\Exception;

class Whoops{
    public function app_begin( &$params )
    {
        if ( C('WHOOPS')===false ) {
            // 为false  强制禁用
            return;
        }else if (C('WHOOPS')===true) {
            // 为true  强制启用
            $this->register();
            return;
        }else if ( APP_DEBUG==false ) {
            // 其他情况根据 APP_DEBUG
            return;
        }else{
            $this->register();
        }
    }

    public function register()
    {
        $whoops = new \Whoops\Run;
        $pretty = new \Whoops\Handler\PrettyPageHandler;
        $whoops->pushHandler($pretty);
        $jsonHandler = new \Whoops\Handler\JsonResponseHandler();
        $jsonHandler->onlyForAjaxRequests(true);
        $whoops->pushHandler($jsonHandler);
        $whoops->register();
        restore_error_handler();
        spl_autoload_register(array($this,'autoload'));

    }

    public function autoload($class)
    {
        $loaders = spl_autoload_functions();
        $last = end($loaders);
        if ($last[0]==$this) {
            throw new Exception('类不存在:'.$class );
        }
    }
}


if (class_exists( 'Snowair\Think\Behavior\HookAgent' )) {
    \Snowair\Think\Behavior\HookAgent::add('app_begin','Snowair\\Whoops');
}

