<?php
session_start();
include 'connect_db.php';
$uname=$_POST["uname"];
$pass=$_POST["pass"];
//$usertype=$_POST["usertype"];

//echo $uname;
//echo $pass;

$err = array() ;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  
  if (empty($uname))
     $err[0] = "username no. is required"; 
  // else	
     //if (!preg_match("/^[789]{1}[0-9]{4}[0-9]{5}$/i",$umobile))
	   //$err[0] = "Mobile number in-valid"; 


 
 // if(!(strlen($pass)>5))
  //{
//	 $err[1]="Password is not correct";
 // }
 if (empty($pass))
   $err[1] = "Password is required"; 
   
}
 
if(!empty($err))
{
	echo 'inside if';
$_SESSION['error4']=$err;
header('Location: home.php');
}
else
{
$sql="SELECT * FROM user WHERE u_name='$uname' and pass='$pass'";
$result=mysqli_query($con,$sql);
$count=mysqli_num_rows($result);
if($count==1)
{
$_SESSION["username"]=$uname;
//$_SESSION["usertype"]=$usertype;
//session_register("pass"); 
header("location: home.php");
}
else 
{
	echo "inside else";
$_SESSION['error5']= " **Wrong Username or Password";
header("location:home.php");
}
}
?>
 