<script type="text/javascript">
//call function reload on click of edit
function edit_expenses(amount,type,date,id) {
	//alert("3");
	
	//alert(id);
	var chg = "<td>"+
     	 "<select name=\"type\">" +
     	 	"<option value=\"misc\" selected><\/option> " +
     	 	"<option value=\"mobilebill\">Mobile Bill<\/option>" +
     	 	"<option value=\"restaurant\">Restaurant<\/option>" +
     	 	"<option value=\"petrol\">Petrol<\/option>" +
     	 	"<option value=\"shopping\">Shopping<\/option>" +
     	 	"<option value=\"groceries\">Groceries<\/option>" +
     	 "<\/select>" +
     	 "<\/td>" +
		"<td>" +
			"<input type=\"number\" name=\"amount\" value="+amount+"></td>" +
		"<td>" +
     	 	"<input type=\"date\" name=\"date\" value="+date+">" + 
     	 "<\/td>" +
		"<td><a href=\"#\" onclick=\"update('"+amount+"','"+type+"','"+date+"','"+id+"')\">Update<\/a><\/td>" +
		"<td><a href=\"#\" onclick=\"cancel_expenses('"+amount+"','"+type+"','"+date+"','"+id+"')\">Cancel<\/a><\/td>";
	//alert (chg);
	document.getElementById(id).innerHTML = chg;	
}
// call function cancel on click of cancel
function cancel_expenses(amount,type,date,id) {
	//alert("3");
	
	//alert(id);
	var chg = "<td>"+type+
     	 "<\/td>" +
		"<td>" +amount+"</td>" +
		"<td>" +date + 
     	 "<\/td>" +
		"<td><a href=\"#\" onclick=\"edit_expenses('"+amount+"','"+type+"','"+date+"','"+id+"')\">Edit<\/a><\/td>" +
		"<td><a href=\"#\" onclick=\"cancel('"+amount+"','"+type+"','"+date+"','"+id+"')\">Delete<\/a><\/td>";
	//alert (chg);
	document.getElementById(id).innerHTML = chg;
}

function delete_expenses(id) {
	//alert("3");
	
	//alert(id);
	//alert (rel_year);
	//alert(info);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(id).innerHTML = this.responseText;
    }
  };
//if (x=="images")
{
	var info = "id="+id;
  	xhttp.open("POST", "delete_expenses.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send(id);
}
}
	
function get_expenses()
{
	 var value_exp = document.getElementById('value_exp').value;
	 var type_of_value = document.getElementById("type_of_value_exp").value;
	//alert(value_of);
	 var xhttp = new XMLHttpRequest();
	 xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_exp").innerHTML = this.responseText;
    }
  };
//if (x=="images")
{
	var info = "value="+value_of+"&type_of_value="+type_of_value;
  	xhttp.open("POST", "get_expenses.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send(info);
}
}
	
</script>

<div id="main_exp">

<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

$euname = $_SESSION["username"];
//echo $uname;

//if (isset($_POST['submit'])) {
   // $value = $_POST['value'];
   // $type_of_value = $_POST['type_of_value'];
	//echo $value.$type_of_value;
 // }	

?>

Expenses from last 30 days<br>
Show expenses for last

  <input type="number" name="value" min="1" max="365" value="30" id="value_exp">
  <select name="type_of_value_exp" id="type_of_value">
	<option value="days" selected>Days</option>
	<option value="months">Months</option>
</select> 


 <button type="submit" name="submit" onClick="get_expenses()";>Display</button>
	
 



<?php

//display expenses from last month

$exp_qry= "select * from expenses WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
ORDER BY DATE(date) desc"; //and date >= CURRENT_TIMESTAMP -30";

$exp_rs=mysqli_query($con,$exp_qry) OR die(mysqli_error($con));

//$num_rows = mysqli_num_rows($exp_rs);

//echo $num_rows;

?>

<table width="500">
<tbody>
	<tr>
		<td>Type</td>
		<td>Amount</td>
		<td>Date</td>
		<td>Edit</td>
		<td>Delete</td>
	</tr>
	
<?php
while($exp_rw=mysqli_fetch_row($exp_rs))
{
	//echo "inside while";
	//echo $rw[0];
	//echo "inside while".$exp_rw[4];
	
?>

<!-- create id on each table row so that it changes according to the click of edit  -->
	<tr id="<?php echo "expenses".$exp_rw[4]; ?>">
		<td>
		<?php echo $exp_rw[2];  ?>
		</td>
		<td>
		<?php echo $exp_rw[1];   ?>
		</td>
		<td>
		<?php echo $exp_rw[3];   ?>
		</td>
		<td><a href="#" onClick="edit_expenses(<?php echo "'".$exp_rw[1]."','".$exp_rw[2]."','".$exp_rw[3]."','expenses".$exp_rw[4]."'"; ?>)";>Edit</a></td>
		<td><a href="#" onClick="delete_expenses(<?php echo $exp_rw[4]; ?>)";>Delete</a></td>
	</tr>


<?php
	
}

?>
</tbody>
</table>

Show Custome income

</div>