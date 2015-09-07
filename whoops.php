<?php

namespace Snowair;

class Whoops{
    public function app_init( &$params )
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

const DS = DIRECTORY_SEPARATOR;
$vendorPath   = dirname(dirname(__DIR__));
$vendorParent = realpath(dirname($vendorPath));

function getProjectRoot($vendorParent){
    $dir = dirname($vendorParent);
    if ( file_exists($vendorParent. DS .'composer.json')
        || file_exists( $vendorParent.DS.'.git')
        || file_exists( $vendorParent.DS.'index.php' )
    )
    {
        return $vendorParent;
    }elseif( $dir!=$vendorParent && $dir!='.' ){
        return getProjectRoot($dir);
    }else{
        return false;
    }
}

$rootPath = getProjectRoot($vendorParent);
if ($rootPath) {
    $dir = dir($rootPath);
    $index = $basepath = false;
    while($d=$dir->read()){
        if($d=='index.php'){
            $basepath = $rootPath;
            $index = $rootPath.DS.'index.php';
            break;
        }
        if(file_exists($rootPath.DS.$d.DS.'index.php') ){
            $basepath = $rootPath.DS.$d;
            $index = $rootPath.DS.$d.DS.'index.php';
            break;
        }
    }
    if ($index && $basepath) {
        $content = file_get_contents($index);
        if (preg_match_all('/define.*[\'"](\w+)[\'"].*((?<=[\'"]).+(?=[\'"])|true|false)/im',$content,$matches,PREG_SET_ORDER)) {
            $const = array();
            foreach ($matches as $value) {
                $const[$value[1]]=$value[2];
            }
        }
        if ( preg_match( '{.*[\'"](.*ThinkPHP.php)[\'"]}',$content,$matches ) ) {
            $think_path = dirname(realpath($basepath.DS.$matches[1]));
            include_once $think_path.DS.'Library'.DS.'Think'.DS.'Hook.class.php';
            if (class_exists('Think\Hook')) {
                \Think\Hook::add('app_init','Snowair\\Whoops');
            }
        }
    }
}

