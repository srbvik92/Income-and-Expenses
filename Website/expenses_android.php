<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

//$uname = $_POST['uname'];
$uname = "srbvik92";

//echo $uname;

//calculate income of last 4 months



$month = array ("","January","February","March","April","May","June","July","August","September","October","November","December");

//echo "value ".$inc_date[0][0];



//calculate different type of expenses from last 30 days

$exp_qry = "select amount, type from expenses where u_name='$uname' and Date(date) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";

$exp_rs = mysqli_query($con,$exp_qry) OR die(mysqli_error($con));

$exp_type = array();

header('Content-type: application/json');

$i=0;
//while($exp_rw = mysqli_fetch_row($exp_rs))
{
	//$exp_type[$i] = array($exp_rw[0],$exp_rw[1]);
	//$i++;
}

$data = array();


		  //add data to chart looping all results
while ($exp_rw = mysqli_fetch_row($exp_rs)){
	
	array_push($data, array('amount'=>$exp_rw[0], 'type'=>$exp_rw[1]));
			  
}

print_r(json_encode($data));

?>

    
        
    