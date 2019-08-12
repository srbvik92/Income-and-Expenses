<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

//get username from android
$uname = $_POST['username'];
//$uname = "srbvik92";

//$exp_qry = "select amount, type from expenses where u_name='$uname' and Date(date) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";

$exp_qry = "select sum(amount), type from expenses where u_name='$uname' and Date(date) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) group by type";

$exp_rs = mysqli_query($con,$exp_qry) OR die(mysqli_error($con));

$exp_type = array();

$i=0;
//while($exp_rw = mysqli_fetch_row($exp_rs))
{
	//$exp_type[$i] = array($exp_rw[0],$exp_rw[1]);
	//$i++;
}


?>


<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
   <script type="text/javascript">

          // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
		  
	  <?php
		  //add data to chart looping all results
		  while ($exp_rw = mysqli_fetch_row($exp_rs)){
			  ?>
        ['<?php echo $exp_rw[1]; ?>', <?php echo $exp_rw[0]; ?>],  <?php }  ?>
      ]);

// Set chart options
      var options = {'title':'Share of expenses from last month',
           'width':400,
           'height':300,
		   'left':10 };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
    
   	</head>
   	
   <div id="chart_div" style="width:300; height:300; float: left;"></div>