<style>

.topbar
{
	overflow: hidden;
	float: none;
	background-color: #0080F0;
}

.topbar a
{
	float: left;
    font-size: 16px;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.topbar p
{
	float: left;
    font-size: 16px;
    color: #C8C4C4;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}


.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .dropbtn {
    font-size: 16px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
}

.topbar a:hover, .dropdown:hover .dropbtn {
    background-color: red;
}
	
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}
	
</style>


<div class="topbar">
  <a href="home.php" style="margin-left: 250px;">Home</a>
 
  <div class="dropdown">
    <button class="dropbtn">Welcome <?php echo $_SESSION["username"];  ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Change Password</a>
      <a href="#">Modify Personal Details</a>
      <a href="#"></a>
    </div>
  </div> 
  <a href=logout.php>Logout</a>
  <a href=income_and_expenses.php>My income and expenses</a>
  <div></div>
</div>


