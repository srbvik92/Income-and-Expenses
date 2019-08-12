<?php
echo "registeruser";
session_start();

include 'connect_db.php';

$user_name=$_POST['user_name'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$name=$_POST['name'];

$rs=mysqli_query($con,"select email from user where email='$email'");


$regerr = array();

//check if username already exists
$erqry1="select u_name from user where u_name='$user_name'";

$errs1=mysqli_query($con,$erqry1) OR die(mysqli_error($con));

$exist1=mysqli_fetch_row($errs1);

if(!empty($exist1))
{
	$regerr[0]="User name has been taken, please try other";
}

//check if email already exists
$erqry2="select email from user where email='$email'";

$errs2=mysqli_query($con,$erqry2) OR die(mysqli_error($con));

$exist2=mysqli_fetch_row($errs2);

if(!empty($exist2))
{
	$regerr[1]="Email has been taken, please try other";
}

if(!empty($regerr))
{
	$_SESSION['error']=$regerr;
	header('Location: register.php');
}


//echo $pass;

//if($rw=mysql_fetch_row($rs))
//{
//$err[4]="* Account related to email already exists. Please try another email or click into forgot password";
//}

$qry="insert into user values('$user_name','$email','$pass','$name')";


mysqli_query($con,$qry) OR die(mysqli_error($con));

header('Location: home.php');

?>