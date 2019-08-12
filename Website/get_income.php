<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

$euname = $_SESSION["username"];

$value = $_POST['value_inc'];
$type_of_value = $_POST['type_of_value_inc'];

//echo "ajax".$value.$type_of_value;

?>


Income from last <?php echo $value." ".$type_of_value; ?>
<br>

Show income for last 

  <input type="number" name="value" min="1" max="365" value="<?php echo $value; ?>" id="value_inc">
  <select name="type_of_value" id="type_of_value_inc">
	<option value="days" <?php if($type_of_value=="days") echo "selected" ?>></option>Days</option>
	<option value="months" <?php if($type_of_value=="months") echo "selected" ?>>Months</option>
</select> 


 <button type="submit" name="submit" onClick="get_income()";>Display</button>
 
<br>


<?php

//display expenses from last months or days as per user

if($type_of_value == "days")
{
	$inc_qry= "select * from income WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL ".$value." DAY) ORDER BY DATE(date) desc";
}

elseif($type_of_value == "months")
{
	$inc_qry= "select * from income WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL ".$value." MONTH) ORDER BY DATE(date) desc";
}

?>

<table>
<tbody>
<tr>
	<td>Month</td>
	<td>Amount</td>
	<td>Edit</td>
	<td>Delete</td>
</tr>
<?php

//$inc_qry= "select * from income WHERE u_name='$euname' and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) ORDER BY DATE(date) desc";// and date >= CURRENT_TIMESTAMP -360";

$rs = mysqli_query($con,$inc_qry) OR die(mysqli_error($con));

while($rw=mysqli_fetch_row($rs))
{
	//echo "inside while".$rw[3];
?>
	<!-- create id on each table row so that it changes according to the click of edit  -->
	<tr id="<?php echo "income".$rw[3]; ?>">
	<td><?php echo date("F", strtotime($rw[2])); ?></td>
	<td><?php echo $rw[1]; ?></td>
	<td><a href="#" onClick="edit_income(<?php echo "'".$rw[1]."','".$rw[2]."','income".$rw[3]."'"; ?>)";>Edit</a></td>
	<td><a href="#" onClick="delete_income(<?php echo $rw[3]; ?>)";>Delete</a></td>
	</tr>
<?php
}
?>



</tbody>	
</table>