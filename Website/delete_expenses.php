<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
include 'connect_db.php';

$id = $_POST["id"];

$qry = "delete from expenses where id='$id''";

$rs = mysqli_query($con,$rs) OR die(mysqli_error($con));

?>


<td>Successfuly Deleted</td>
<td></td>
<td></td>
<td></td>
<td></td>