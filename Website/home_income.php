<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

$uname = $_SESSION["username"];

   /* Include the ../src/fusioncharts.php file that contains functions to embed the charts.*/
   include("includes/fusioncharts.php");

$inc_qry="select amount, MONTH(date) from income where u_name='$uname' and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH) ORDER BY DATE(date) desc";

$inc_rs = mysqli_query($con,$inc_qry) OR die(mysqli_error($con));

$i=0;
while($inc_rw = mysqli_fetch_row($inc_rs))
{
	//echo $inc_rw[0];
	$inc_date[$i] = array($inc_rw[0],$inc_rw[1]);
	$i++;
	
}

//echo "value ".$inc_date[0][0];

$month = array ("","January","February","March","April","May","June","July","August","September","October","November","December")

?>
<html>

<head>
    <title>FusionCharts | My First Chart</title>

    // Include FusionCharts core file
    <script src=" http://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script> 

    // Include FusionCharts Theme File
    <script src=" http://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script> 
</head>

<body>
    <?php
    // Chart Configuration stored in Associative Array
    $arrChartConfig = array(
        "chart" => array(
            "caption" => "Last four months income",
            "subCaption" => "In MMbbl = One Million barrels",
            "xAxisName" => "Month",
            "yAxisName" => "Amount (in INR)",
            "numberSuffix" => "INR",
            "theme" => "fusion"
        )
    );
    // An array of hash objects which stores data
    $arrChartData = array(
        [$month[$inc_date[0][1]], $inc_date[0][0]],
        [$month[$inc_date[1][1]], $inc_date[1][0]],
        [$month[$inc_date[2][1]], $inc_date[2][0]],
        [$month[$inc_date[3][1]], $inc_date[3][0]],
    );

    $arrLabelValueData = array();

    // Pushing labels and values
    for($i = 0; $i < count($arrChartData); $i++) {
        array_push($arrLabelValueData, array(
            "label" => $arrChartData[$i][0], "value" => $arrChartData[$i][1]
        ));
    }

    $arrChartConfig["data"] = $arrLabelValueData;

    // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
    $jsonEncodedData = json_encode($arrChartConfig);

    // chart object
    $Chart = new FusionCharts("column2d", "MyFirstChart" , "700", "400", "chart-container", "json", $jsonEncodedData);

    // Render the chart
    $Chart->render();
    ?>

    <center>
        <div id="chart-container">Chart will render here!</div>
    </center>
</body>
</html>