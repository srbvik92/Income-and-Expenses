<?php
session_start();
include 'connect_db.php';
$uname=$_POST['uname'];
$pass=$_POST['pass'];

//$uname = "srbvik92";
//$pass = "123456";
//$usertype=$_POST["usertype"];

error_log("\r\nusername is :".$uname,3,"error.log");

//echo $uname;
//echo $pass;

$err = array() ;


$sql="SELECT * FROM user WHERE u_name='$uname' and pass='$pass'";
$result=mysqli_query($con,$sql);
$count=mysqli_num_rows($result);
header('Content-type: application/json');
if($count==1)
{
$_SESSION["username"]=$uname;
//$_SESSION["usertype"]=$usertype;
//session_register("pass"); 
//header("location: home.php");
	print_r(json_encode(['code'=>'success','uname'=>$uname]));
}
else 
{
	//echo "inside else";
//$_SESSION['error5']= " **Wrong Username or Password";
//header("location:home.php");
	print_r(json_encode(['code'=>'username and password mismatch']));
}

?>
 