<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
?>
         

         <style>
          .error {color: #FF0000;}
        </style>


<form method="post" action="register_user.php">

<table width="100%" height="313" border="0">
  <tr>
    <td width="47%">User Name:</td>
    <td width="53%"><input type="text" name="user_name" required   pattern="[a-zA-Z][a-zA-Z0-9].{6,16}" />&nbsp;<span class="error"><?php echo $_SESSION['error'][0]; ?> 
	</span>
 </td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><input type="email" name="email" required />&nbsp;
    <span class="error"><?php echo $_SESSION['error'][1] ; ?> </span>
    </td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" required name="pass" minlength="6" maxlength="16" />&nbsp;</td>
  </tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="name" required />&nbsp;</td>
  </tr>
  
  <tr>
    <td></td>
    <?php unset($_SESSION['error']); ?>
    <td><input type="submit" name="Register" />&nbsp;</td>
  </tr>
</table>

</form>