<?php
//todo Add debug mode with error display control
//todo Make sample index.page and sample admin page

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$param_pos = strpos($url,'?');
$clear_request_uri = substr($url, 0, $param_pos !== false ? $param_pos : strlen($url));

define('CLEAR_REQUEST_URI', 'http://' . $_SERVER['SERVER_NAME'] . '/' ); //Used for link generation
define('BASEDIR', dirname(__FILE__)."/"); //Used for addressing

include BASEDIR.'sm/init.php';