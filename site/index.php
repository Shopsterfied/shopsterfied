<?php

  if (isset($_POST['user']) && isset($_POST['pass'])) {
	  
	  $name = $_POST['user'];
	  $password = $_POST['pass'];
	  $passhash = md5($password . "^YH7uj*IK9ol");
	  
	  $dbConnected = mysql_connect("localhost", "shopsterfieduser", "hrnxUuxnT57RnZmZ")
		  or die('Failed to connect:  '.mysql_error());
		  
	  mysql_select_db('shopsterfied', $dbConnected)
		  or die('Connected but could not find database: '.mysql_error());
		  
	  $query = "SELECT password FROM Users WHERE user_name = '$name'";
	  $dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  $arrRecord = mysql_fetch_row($dbRecord);
	  
	  
	  if ($passhash == $arrRecord[0]) {    
		  header("Location: http://ec2-52-87-179-178.compute-1.amazonaws.com/shop.php"); /* Redirect browser */
		  /* Make sure that code below does not get executed when we redirect. */
		  exit;
	  } else {
		  echo '<h3>Username ' . $name . ' / Password ' . $passhash . ' Invalid, please try again.</h3>';
	  }
	  
  } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopsterfied</title>
    <link rel="stylesheet" href="static/css/furtive.css">
    <link rel="stylesheet" href="static/css/font-awesome.css">
    <link rel="stylesheet" href="static/css/site.css">
    <script type="text/javascript" src="static/js/jquery.js"></script>
    <script type="text/javascript" src="static/js/signin.js"></script>
</head>
<body>
    <div class="bg--off-white py2 measure">
        <div class="txt--center">
            <h1><i class="fa fa-shopping-bag"></i> Shopsterfied<h1>
        </div>

    <form id="signin" class="px2" method = "post" action="index.php" role="form">
        <label for="user">Username</label>
        <input type="text" id="user" name="user" placeholder="Username">
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass" placeholder="8 or more characters...">
        <div class="grd-row">
            <a class="btn--gray grd-row-col-4-6" id="submit">Enter</a>
            <a class="btn--link grd-row-col-2-6" href="register.php">Or Sign up...</a>
        </div>
    </form>
    </div>
</body>
</html>
