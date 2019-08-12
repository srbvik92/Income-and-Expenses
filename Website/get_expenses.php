<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

$euname = $_SESSION["username"];
//echo $uname;

$value = $_POST['value'];
$type_of_value = $_POST['type_of_value'];

//echo "ajax".$value.$type_of_value;

?>


Expenses from last <?php echo $value." ".$type_of_value; ?><br>
Show expenses for last <input type="number" id="value" name="value" min="1" max="365" value="<?php echo $value; ?>"><select name="type_of_value" id="type_of_value">
	<option value="days">Days</option>
	<option value="months">Months</option>
</select>
 
 <button type="submit" name="submit" onClick="get_expenses()";>Display</button>
	

 <br>


<?php

//display expenses from last months or days as per user

if($type_of_value == "days")
{
	$exp_qry= "select * from expenses WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL ".$value." DAY) ORDER BY DATE(date) desc";
}

elseif($type_of_value == "months")
{
	$exp_qry= "select * from expenses WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL ".$value." MONTH) ORDER BY DATE(date) desc";
}

//$exp_qry= "select * from expenses WHERE u_name='$euname'and DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ORDER BY DATE(date) desc"; //and date >= CURRENT_TIMESTAMP -30";

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