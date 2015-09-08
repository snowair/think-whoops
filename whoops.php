<?php

namespace Snowair;

class Whoops{
    public function app_begin( &$params )
    {
        if (APP_DEBUG==false && !C('WHOOPS')) {
            return;
        }
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

