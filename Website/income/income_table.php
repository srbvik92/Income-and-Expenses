<style>

#main_inc{
	
	
	
}
	
#heading{
	width: 1000px;
	text-align: center;
	height: 30px;
	padding-top: 15px;
	padding-bottom: 15px;
	font-size: 30px;
	background-color:#471213;
	color: white;
	font-family:Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
}
	
	
#heading2{
	font-size: 22px;
	padding: 10px;
	padding-left: 20px;
	width: auto;
	background-color: black;
	color: white;
}
	
#table{
	margin-left: 100px;
			
}
	
#td{
	font-size: 22px;
	width: 150px;
	
}

</style>


<script type="text/javascript">

//change values on click of edit
function edit_income(amount,date_inc,id) {
	//alert("3");
	
	//alert(id);
	var chg = "<td id=\"td\">"+
     	 "<input type=\"date\" name=\"date\" value="+date_inc+">" + 
		 "<td id=\"td\">" +
			"<input type=\"number\" name=\"amount\" value="+amount+"></td>" +
		"<\/td>" +
		"<td id=\"td\"><a href=\"#\" onclick=\"update('"+amount+"','"+date_inc+"','"+id+"')\">Update<\/a><\/td>" +
		"<td id=\"td\"><a href=\"#\" onclick=\"cancel('"+amount+"','"+date_inc+"','"+id+"')\">Cancel<\/a><\/td>";
	//alert (chg);
	document.getElementById(id).innerHTML = chg;	
}

	

// call function cancel on click of cancel
function cancel(amount,date_inc,id) {
	//alert("3");
	
	//alert(id);
	//alert (date_inc);
	
	var year = date_inc.substring(0,4);
	var month = parseInt(date_inc.substring(5,7));
	var date_income = date_inc.substring(8,10);
	var arrmonth = ["","January","February","March","April","May","June","July","August","September","October","November","December"];
	
	var chg = "<td id=\"td\">" +arrmonth[month]+"</td>" +
		"<td id=\"td\">" +amount + 
     	 "<\/td>" +
		"<td id=\"td\"><a href=\"#\" onclick=\"edit_income('"+amount+"','"+date_inc+"','"+id+"')\">Edit<\/a><\/td>" +
		"<td id=\"td\"><a href=\"#\"	 onclick=\"cancel('"+date_inc+"','"+amount+"','"+id+"')\">Delete<\/a><\/td>";
	//alert (chg);
	document.getElementById(id).innerHTML = chg;
}

function get_income()
{
	 var value_inc = document.getElementById('value_inc').value;
	 var type_of_value_inc = document.getElementById("type_of_value_inc").value;
	alert(value_inc);
	 var xhttp = new XMLHttpRequest();
	 xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_inc").innerHTML = this.responseText;
    }
  };
//if (x=="images")
{
	var info = "value_inc="+value_inc+"&type_of_value_inc="+type_of_value_inc;
  	xhttp.open("POST", "get_income.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send(info);
}
}

</script>



<div id="main_inc">

<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

$iuname = $_SESSION["username"];

error_reporting(E_ALL); ini_set('display_errors', '1');

?>

<div id="heading">
Income of last 6 months
	</div>
	

<div id="heading2">
Show income for last   

  &nbsp; <input style="font-size: 22px; " type="number" name="value" min="1" max="365" value="30" id="value_inc"> &nbsp;
  <select style="font-size: 22px;" name="type_of_value" id="type_of_value_inc">
	<option value="days" selected>Days</option>
	<option value="months">Months</option>
</select> 
&nbsp;

 <button style="font-size: 22px; background-color: brown; border: none;" type="submit" name="submit" onClick="get_income()";>Display</button>
</div>


<table width="600" id="table" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr bgcolor="#E0CBCB" bordercolor="#471213"><font color="white">
	<td id="td" >Month</td>
	<td id="td" >Amount</td>
	<td id="td" >Edit</td>
	<td id="td" >Delete</td></font>
</tr>
<?php

$inc_qry= "select * from income WHERE u_name='$iuname' and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
ORDER BY DATE(date) desc";// and date >= CURRENT_TIMESTAMP -360";

$rs = mysqli_query($con,$inc_qry) OR die(mysqli_error($con));
$i=1;
	//echo $i;
while($rw=mysqli_fetch_row($rs))
{
	//echo "inside while".$rw[3];
?>
	<!-- create id on each table row so that it changes according to the click of edit  -->
	<tr id="<?php echo "income".$rw[3]; ?>"
	
	<?php
	//set alternate colors for rows
	if ($i%2==0){echo "bgcolor=\"#E0CBCB\"" ;}?> >
	<td id="td" ><?php echo date("F", strtotime($rw[2])); ?></td>
	<td id="td"><?php echo $rw[1]; ?></td>
	<td id="td"><a href="#" onClick="edit_income(<?php echo "'".$rw[1]."','".$rw[2]."','income".$rw[3]."'"; ?>)";>Edit</a></td>
	<td id="td"><a href="#" onClick="delete_income(<?php echo $rw[3]; ?>)";>Delete</a></td>
	</tr>
<?php $i=$i+1;
}
?>



</tbody>	
</table>


</div>