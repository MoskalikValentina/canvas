<?php
include ('db_conf.inc');

$error = '';
if (isset($_POST['login'])) 
	$login = $_POST['login'];
if ($login == '') 
	unset($login);
if (isset($_POST['password'])) 
	$password = $_POST['password'];
if ($password == '') 
	unset($password);
if (empty($login) or empty($password)){
	$error = 'Логин или пароль не введены';
	return;
}
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
$login = trim($login);
$password = trim($password);


//Database connec
$dbcn = mysql_connect($server, $user, $pass) or die('<p>DataBase connection error</p>'); 
mysql_select_db($dbname, $dbcn) or die('<p>DataBase not found</p>');

$req = "SELECT * FROM %s WHERE login='%s'";
$query = sprintf($req, mysql_real_escape_string($tbl_users),mysql_real_escape_string($login));
$result = mysql_query($query);
$user_row = mysql_fetch_array($result);
if (empty($user_row['password'])){
	$error = 'Извините, введенный вами логин или пароль неверный.';
	return;
} else {
	if ( $user_row['password'] != $password ){
		$error = 'Извините, введенный вами логин или пароль неверный.';
		return;
	} else {
		if ($user_row['access_tbl'] != $tbl_req){
			$error = 'Извините, но Вам отказано в доступе.';
			return;
		} else {
			$_SESSION['login'] = $user_row['login'];
			$_SESSION['id'] = $user_row['id'];
		}
	}
}