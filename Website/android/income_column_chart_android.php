<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

//get username from android
//$uname = $_POST['username'];
$uname = "srbvik92";

//calculate income of last 4 months

$inc_qry="select amount, MONTH(date) from income where u_name='$uname' and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH) ORDER BY DATE(date) desc";

$inc_rs = mysqli_query($con,$inc_qry) OR die(mysqli_error($con));

$inc_date = array();

$i=0;
//while($inc_rw = mysqli_fetch_row($inc_rs))
{
	//echo $inc_rw[0];
	//$inc_date[$i] = array($inc_rw[0],$inc_rw[1]);
	//$i++;
	
}

$month = array ("","January","February","March","April","May","June","July","August","September","October","November","December");

?>

   
<!-- column chart -->
   <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    
	 // Load the Visualization API and the Columnchart package.
	  
    google.charts.load("current", {packages:['corechart']});
	
	// Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
	  
	// Callback that creates and populates a data table, 
      // instantiates the column chart, passes in the data and
      // draws it.
    function drawChart() {
		
	// Create the data table.
      var data = google.visualization.arrayToDataTable([
        ["Month", "Income", { role: "style" } ],
	  <?php 
		  while($inc_rw = mysqli_fetch_row($inc_rs)) {
		  ?>
        ["<?php echo $month[$inc_rw[1]]; ?>",<?php echo $inc_rw[0]; ?>, "#b87333"],  <?php }  ?>
        
      ]);  

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
	// Set chart options
      var options = {
        title: "Last four montth's income",
        width: 400,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
		
      };
		
	// Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
  
  <div id="columnchart_values" style="width: 400px; height: 400px; float: left;"></div>
 