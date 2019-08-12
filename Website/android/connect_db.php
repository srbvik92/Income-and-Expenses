<?php

//error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

//include 'globals.php';

$config = parse_ini_file('../../private/eandi_config.ini'); 

//echo Globals::$host."bubi";

global $con;

$android_root = $config['android_root'];

//echo $server_root;

//$con=mysqli_connect(Globals::$host, Globals::$db_user, Globals::$db_pass);
//mysqli_select_db($con,Globals::$db_name) OR die(mysqli_error());

$con = mysqli_connect($config['host'], $config['username'], $config['password']);

mysqli_select_db($con, $config['dbname']) OR die(mysqli_error($con));

?>