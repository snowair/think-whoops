<?php

if (!function_exists( 'whoops' )) {
    function whoops(){
        if (defined('APP_DEBUG') && APP_DEBUG==false) {
            if (defined('WHOOPS') && WHOOPS==true) {
            }else{
                // 非debug模式, 禁用whoops
                return;
            }
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

