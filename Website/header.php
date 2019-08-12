<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
  
error_reporting(E_ALL);
		
		$uname=$_SESSION['username'];
		
		if(!(strcmp($uname,"")))
		{
			include 'login.php';
		}
		else
		{
			include 'user_details.php';
		}
		?>