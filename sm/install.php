<?php

//todo Make protect when used DB field name with minus ("-"). It`s make install errors
//todo Add install process configuration
//todo Add check exist all needs dirs
//todo Add visualization install process

//DB connection prepare
require_once BASEDIR.'sm/core/db/DBConnect.class.php';
require_once BASEDIR.'sm/core/db/DBTbl.class.php';
//Make connection
$config = configLoad();
$db_connection = DBConnect::withConfig($config);
$db_connection->DBSel();


require_once BASEDIR.'sm/core/db/DBInstaller.class.php';
//Install request tbl
$tbl_name = $config->req_tbl_name();
$tbl_structure = $config->req_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
if($installer->installTBL())
    echo $tbl_name . ' installed<br>';

//Install productt tbl
$tbl_name = $config->prod_tbl_name();
$tbl_structure = $config->prod_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
if($installer->installTBL())
    echo $tbl_name . ' installed<br>';

//Install users tbl
$tbl_name = $config->users_tbl_name();
$tbl_structure = $config->users_tbl_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
if($installer->installTBL())
    echo $tbl_name . ' installed<br>';

//Add new user //todo make user autocreation
$login = 'test123';
$password = '12345';
$access_tbl = $config->req_tbl_name();
$hashed_password = crypt($password);

$params = array(
    'login' => $login,
    'password' => $hashed_password,
    'access_tbl' => $access_tbl
);
$tbl = new DBTbl($config->users_tbl_name(), $config->users_tbl_structure(), $db_connection);
if($tbl->write($params))
    echo 'User added <br>';