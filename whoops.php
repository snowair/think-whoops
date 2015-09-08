<?php

namespace Snowair;

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
    }
}

if (class_exists( 'Snowair\Think\Behavior\HookAgent' )) {
    \Snowair\Think\Behavior\HookAgent::add('app_begin','Snowair\\Whoops');
}

