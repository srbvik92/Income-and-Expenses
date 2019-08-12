<?php
session_start();
include 'connect_db.php';
error_reporting(E_ALL); ini_set('display_errors', '1');

$uname = $_SESSION["username"];

$amount = $_POST["amount"];
$month = $_POST["date"];

$id_qry="select MAX(id) from income";
		
		$id_res=mysqli_query($con,$id_qry) OR die(mysqli_error($con));
		
		$id_row=mysqli_fetch_row($id_res);
		
		$id=$id_row[0];
		$id=$id+1;

$qry = "insert into income values ('$uname','$amount','$month','$id')";

$rs=mysqli_query($con,$qry) OR die(mysqli_error($con));

header("location: home.php");

?>