<?php
/**
 * Init
 */
$status = '';
define('SM_VERSION', 'SM v.2.6.0');

//Session start
if(session_id() == '')
    session_start();


/**
 * Config load
 */
function configLoad(){
    $config_file_path = BASEDIR.'sm/config/config.php';
    if(!file_exists($config_file_path))
    {
        echo 'Config not found';
        exit;
    }
    require_once BASEDIR.'sm/core/Config.class.php';
    $config = new Config();
    $config->load_conf($config_file_path);
    return $config;
}

//Router init
require_once BASEDIR . 'sm/CustomRouter.php';

$router = new CustomRouter();
// $router->subDirInit(); //Use if work with subdirectory
$router->init();



//todo make unit test for all
//todo add cleaning tmp/import after importing
//todo Make readme with description
//todo Send AJAX requests and answers in JSON
//todo Optimize (remote excess, db requests, clean code etc)
//todo Change properties private -> protected