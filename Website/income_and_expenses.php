<style>

.header{
	position: static;
	height: 45px;
	background-color: aqua;
	
}
	
.topmenu{
	width:1000px;
	height:55px;
	margin:auto;
	alignment-adjust:central;
	
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
	width: 500px;
	height: auto;
}

#rightmain
{
	left: 500px;
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


<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors', '1');	
?>

<div class="header">
	<?php
	
	include 'header.php';
	?>
</div>

<div class="topmenu">
	<?php
		include 'top_menu.php';
	?>
	
</div>

<div class="main">
	
	<div id="leftmain">
		<?php
			include 'expenses.php';
		?>
	</div>
	
	<div id="rightmain">
		<?php
			include 'income.php';
		?>
	</div>
	
	
</div>


<div class="footer">
	<?php
		include 'footer.php';
	?>
	
</div>	