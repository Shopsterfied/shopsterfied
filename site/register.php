<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <title>Shopsterfied</title>
    <link rel="stylesheet" href="static/css/furtive.css">
    <link rel="stylesheet" href="static/css/font-awesome.css">
    <link rel="stylesheet" href="static/css/site.css">
    <script type="text/javascript" src="static/js/jquery.js"></script>
    <script type="text/javascript" src="static/js/register.js"></script>
</head>
<body>

<?php

	if (isset($_POST['first-name'])){
		if (isset($_POST["last-name"])){
			if (isset($_POST["user"])){
				if (isset($_POST["pass"])){
	
	 
	  $dbConnected = mysql_connect("localhost", "shopsterfieduser", "hrnxUuxnT57RnZmZ")
		  or die('Failed to connect:  '.mysql_error());
		  
	  mysql_select_db('shopsterfied', $dbConnected)
		  or die('Connected but could not find database: '.mysql_error());
			  
	  $username = $_POST["user"];
	  $firstname = $_POST["first-name"];
	  $lastname = $_POST["last-name"];
	  $password = $_POST["pass"];
	  $passhash = md5($password . "^YH7uj*IK9ol");
	  $msg = "";  // message to display in the event that input validation fails
	  
	  // Ensure email is not already in the database
	  $query = "SELECT user_name FROM Users WHERE user_name = '$username'";
	  $dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  $numRows = mysql_num_rows($dbRecord);
	  if ($numRows != 0)
	  	$msg .= "<p>User already exists</p>";
		
	  // If no error message was generated above, insert new record into the users table of the database
	  if ($msg == ""){
	  	$dbRecord = mysql_query("INSERT INTO `Users`(`user_name`, `first_name`, `last_name`, `password`) VALUES ('$username','$firstname','$lastname','$passhash');", $dbConnected)
					  or die("Could not update SQL table:  ".mysql_error());			  
	  	echo "<p>Registration Successful!  <a href='index.php'>Click here</a> to continue to login.</p>";
	  }
	  else {
	  	echo $msg;
		echo "<p class=\"fnt--red\">Registration NOT Successful!  Please try again.</p>";
	  }
	}}}}
	
    
?>



    <div class="bg--off-white py2 measure">
        <div class="txt--center">
            <h1><i class="fa fa-shopping-bag"></i> Shopsterfied<h1>
        </div>

    <form id="regform" class="px2" action="register.php" method="post" role="form">
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" name="first-name" placeholder="First Name" tabindex="1"/>
        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="last-name" placeholder="Last Name" tabindex="2"/>
        <label for="user">Username</label>
        <input type="text" id="user" name="user" placeholder="Username" tabindex="3"/>
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass" placeholder="8 or more characters..."tabindex="4"/>
        <div class="grd-row">
            <a id="submitreg" class="btn--gray grd-row-col-4-6" tabindex="5">Submit</a>
            <h4 hidden id="input-msg" class="txt--center ">Message text</h4>
        </div>
    </form>
    </div>
</body>
</html>
