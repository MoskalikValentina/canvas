<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$param_pos = strpos($url,'?');
$clear_request_uri = substr($url, 0, $param_pos !== false ? $param_pos : strlen($url));

define('CLEAR_REQUEST_URI', $clear_request_uri ); //Used for link generation
define ('BASEDIR', dirname(__FILE__)."/"); //Used for addressing

include BASEDIR.'sm/engine.php';