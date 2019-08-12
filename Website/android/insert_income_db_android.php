<?php
session_start();
include '../connect_db.php';
error_reporting(E_ALL); ini_set('display_errors', '1');

$uname = $_POST["username"];

$amount = $_POST["amount"];
$date = $_POST["date"];

error_log("\r\ndate is :".$date,3,"error.log");

$id_qry="select MAX(id) from income";
		
	$id_res=mysqli_query($con,$id_qry) OR die(mysqli_error($con));
		
	$id_row=mysqli_fetch_row($id_res);
		
	$id=$id_row[0];
	$id=$id+1;
		


$qry = "insert into income values ('$uname','$amount', STR_TO_DATE('$date','%d-%m-%Y'),'$id')";

$rs=mysqli_query($con,$qry) OR die(mysqli_error($con));

if($rs){
	print_r(json_encode(['code'=>"success"]));
}
else{
	print_r(json_encode(['code'=>"fail"]));
}

//print_r(json_encode($data));

//error_log("\r\nbubi",3,"error.log");

//header("location: home.php");

?>

