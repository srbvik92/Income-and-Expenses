<?php
error_reporting(E_ALL);
session_start();

?>


<style>

.header{
	position: static;
	height: 45px;
	background-color: aqua;
	
}
	
.topmenu{
	width: 1000px;
	height: 55px;
	margin: auto;
	alignment-adjust: central;
	
}
	
.header2
{
	width:1000px;
	height:400px;
	margin:auto;
	alignment-adjust:central;
}
	
.latest_games{
	width: 1000px;
	height: 400px;
	margin:auto;
	alignment-adjust:central;
	background-color: antiquewhite;
		
}

.main
{
	width: 1000px;
	height: 600px;
	alignment-adjust:central;
	margin: auto;
	position: relative;
}

#leftmain
{
	position: absolute;	
	width: 700px;
	height: auto;
}

#rightmain
{
	left: 700px;
	position: absolute;
	width: 300px;
	border-radius: 5px;
	border: thin;
	
	padding-left: 5px;
}
	
.footer
{
	position: static;
	width:1000px;
	height:100px;
	alignment-adjust:central;
	background-color:#c0c0c0;
	margin: auto;
	padding-top: 15px;
}
	
</style>




<div class="header">
	<?php
	
	include 'header.php';
	?>
</div>

<div class="topmenu">
	<?php
	if(isset($_SESSION["username"])){
		include 'top_menu.php';
	}
	else{}
	?>
	
</div>

<div class="main">
	
	<?php
	if(isset($_SESSION["username"])){
		include 'income/income_table.php';
	}
	else{
		include 'home_intro.php';
	}
	?>
	
	
</div>


<div class="footer">
	<?php
		include 'footer.php';
	?>
	
</div>	