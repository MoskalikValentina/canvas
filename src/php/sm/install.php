<?php

$config_file_path = BASEDIR.'sm/core/config/config.php';

//Config load
require_once BASEDIR.'sm/core/config.class.php';
$config = new Config();
$st = $config->load_conf($config_file_path);

//DB connection prepare
require_once BASEDIR.'sm/core/db/DBConnect.class.php';
require_once BASEDIR.'sm/core/db/DBTbl.class.php';
//Make connection
$db_connection = DBConnect::withConfig($config);
$db_connection->DBSel();


require_once BASEDIR.'sm/core/db/DBInstaller.class.php';
//Install request tbl
$tbl_name = $config->req_tbl_name();
$tbl_structure = $config->req_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
$installer->installTBL();

//Install request tbl
$tbl_name = $config->prod_tbl_name();
$tbl_structure = $config->prod_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
$installer->installTBL();

//Install users tbl
$tbl_name = $config->users_tbl_name();
$tbl_structure = $config->users_tbl_structure();
$installer = new DBInstaller($db_connection, $tbl_name, $tbl_structure);
$installer->installTBL();

//Add new user //todo make user autocreation
//$login = 'test12';
//$password = '12345';
//$access_tbl = 'audi_requests';
//$installer->add_user($login, $password, $access_tbl);