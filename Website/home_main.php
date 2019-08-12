<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

if(isset($_SESSION["username"])){
$uname = $_SESSION["username"];
}
//echo $uname;

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

//echo "value ".$inc_date[0][0];



//calculate different type of expenses from last 30 days

$exp_qry = "select amount, type from expenses where u_name='$uname' and Date(date) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";

$exp_rs = mysqli_query($con,$exp_qry) OR die(mysqli_error($con));

$exp_type = array();

$i=0;
//while($exp_rw = mysqli_fetch_row($exp_rs))
{
	//$exp_type[$i] = array($exp_rw[0],$exp_rw[1]);
	//$i++;
}


?>


<style>

.income{
	width: 300px;
	height: 300px;
	margin-top: 10px;
}
	
.share{
	width: 400px;
	height: 300px;
	
}

</style>


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
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>

    
        
    
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
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
		
	// Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
 
 
  <script type="text/javascript">
	  //set date max to current date
  window.onload = function(){
	  var today = new Date();
	  var dd = today.getDate();
	  var mm = today.getMonth()+1; //January is 0!
	  var yyyy = today.getFullYear();
 	if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = yyyy+'-'+mm+'-'+dd;
	  //alert(today);
document.getElementById("date_inc").setAttribute("max", today);
  }
	</script> 
	  
  
  </head>

  <body>
<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:400; height:400; float: left;"></div>
	  
	<div id="columnchart_values" style="width: 600px; height: 400px; float: left;"></div>
	
	
	<div style="width: 500px; float: left;	">
	Enter your expenses to add to your data:
	<form method="post" action="insert_expenses.php">
		<table width="800" border="0">
  		<tbody>
    	<tr>
			<td width="273">Amount:</td>
    		<td width="517"><input type="number" name="amount" min="1"></td>
		</tr>
    	 <tr>
    	 <td>Type of expense:</td>
    	 <td>
     	 <select name="type">
     	 	<option value="misc" selected></option>
     	 	<option value="mobilebill">Mobile Bill</option>
     	 	<option value="restaurant">Restaurant</option>
     	 	<option value="petrol">Petrol</option>
     	 	<option value="shopping">Shopping</option>
     	 	<option value="groceries">Groceries</option>
     	 </select>
     	 </td>
     	 </tr>	
     	 <tr>
     	 <td>
     	 	Date of expense:
     	 </td>
     	 <td>
     	 	<input type="date" name="date">
     	 </td>
     	 </tr>
     	 
     	 
     	 <td><input type="submit" name="submit" /></td>
    	</tr>
  		</tbody>
		</table>

		
		
	</form>	
		
	</div>
	
	<div>
	
	
<?php
//calculate income of last 4 months

$inc_qry="select amount, MONTH(date) from income where u_name='$uname' and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH) ORDER BY DATE(date) desc";

$inc_rs = mysqli_query($con,$inc_qry) OR die(mysqli_error($con));

$inc_date = array();

$i=0;
while($inc_rw = mysqli_fetch_row($inc_rs))
{
	//echo $inc_rw[0];
	$inc_date[$i] = array($inc_rw[0],$inc_rw[1]);
	$i++;
	
}



//echo "value ".$inc_date[0][0];

		
?>
	<form method="post" action="insert_income.php">
	Enter your income to add to data:
	<table>
	<tbody>
	<tr>
		<td>
			Amount:
			
		</td>
		<td>
			<input type="number" name="amount" min="1">
		</td>
	</tr>
	<tr>
		<!--<td>
			Month:
		</td>
		<td>
			<select name="month">
     	 	<option value="" selected></option>
     	 	<option value="jan">January</option>
     	 	<option value="feb">February</option>
     	 	<option value="mar">March</option>
     	 	<option value="apr">April</option>
     	 	<option value="may">May</option>
     	 	<option value="jun">June</option>
     	 	<option value="jul">July</option>
     	 	<option value="aug">August</option>
     	 	<option value="sept">September</option>
     	 	<option value="oct">October</option>
     	 	<option value="nov">November</option>
     	 	<option value="dec">December</option>
     	 	</select>
		</td>-->
		<td>
     	 	Date of income:
     	 </td>
     	 <td>
     	 	<input type="date" name="date" id="date_inc" min='1899-01-01' max='2000-12-13'>
     	 </td>
	</tr>
	</tr>
     	 
     	 
     	 <td><input type="submit" name="submit" /></td>
    	</tr>		
	</tbody>
	</table>
	</form>	
	</div>
	
  </body>
</html>
