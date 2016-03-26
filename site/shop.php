<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopsterfied</title>
    <link rel="stylesheet" href="static/css/furtive.css">
    <link rel="stylesheet" href="static/css/font-awesome.css">
    <link rel="stylesheet" href="static/css/site.css">
    <script type="text/javascript" src="static/js/jquery.js"></script>
    <script type="text/javascript" src="static/js/shop.js"></script>
    
    <?php
		$userid = $_COOKIE['username'];
	  
	  	$dbConnected = mysql_connect("localhost", "shopsterfieduser", "hrnxUuxnT57RnZmZ")
		  	or die('Failed to connect:  '.mysql_error());
		  
	  	mysql_select_db('shopsterfied', $dbConnected)
		  	or die('Connected but could not find database: '.mysql_error());
			
			
		$query = "SELECT `id` FROM `Users` WHERE `user_name` = '$userid'";
	  	$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  	$arrRecord = mysql_fetch_row($dbRecord);
		$ownerid = $arrRecord[0];
			
		if (isset($_POST['buttonval'])){
			
			$btnmsg = $_POST['buttonval'];
			$listname = $_POST['list-name'];
			$itemname = $_POST['item-name'];
			$quantity = $_POST['quantity'];
			$priority = $_POST['priority'];
			$price = $_POST['price'];
			
			
			if ($btnmsg == 'addItem' && trim($listname) != "") {
					 
				$query = "SELECT `id` FROM `Lists` WHERE (`name` = '$listname' AND `owner` = '$ownerid')";
	  			$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				
				if (mysql_num_rows($dbRecord) == 0){
					$query = "INSERT INTO `Lists`(`name`, `owner`) VALUES ('$listname', '$ownerid')";
	  				mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					$query = "SELECT `id` FROM `Lists` WHERE (`name` = '$listname' AND `owner` = '$ownerid')";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				}
	  			$arrRecord = mysql_fetch_row($dbRecord);
				
				$listid = $arrRecord[0];
				$itemInList = False;
				$query = "SELECT `item_name` FROM `Items` WHERE `list` = '$listid'";
				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
			
				while($row = mysql_fetch_assoc($dbRecord)){
					if ($row['item_name'] == $itemname){
						$itemInList = True;
					}
				}
				
				if (trim($itemname) != "" && trim($quantity) != ""
					&& trim($priority) != "" && trim($price) != "" && !$itemInList){
					$query = "INSERT INTO Items(`list`, `item_name`, `cost`, `quantity`, `priority`) 
						VALUES ('$listid','$itemname','$price','$quantity','$priority')";
					mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				}

			}
		}
			
    ?>
    
</head>
<body>
    <header class="txt--center">
        <h1><i class="fa fa-shopping-bag"></i> Shopsterfied<h1>
    </header>
    <div class="bg--off-white py2 px2 measure content">
        <div class"form">
        <form id="shopform" action="shop.php" method="post" role="form">
       
        	<?php
			
				if (isset($_COOKIE['username'])){
					echo '<h4>Signed in as:  ' . $userid . '</h4>';
				}
				else {
					echo '<h4>Not signed in.  <a href="index.php">Click here</a> to sign in.</h4>';
				}
			
				if (isset($_POST['list-name']) && $listname != ""){
					echo '<h4>Selected List:  ' . $listname . '</h4>';
				}
				else {
					echo '<p>Please select a list in the dropdown below or enter a new list name, then click "Add Item"</p>';
				}
			?>
            <label for="list-name">Select or Create List</label>
            <input list="list-names" id="list-name" name="list-name" tabindex="1">
                
            <?php
			
			
            		echo '<datalist id="list-names">';
					
					$query = "SELECT `name` FROM `Lists` WHERE `owner` = '$ownerid'";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					while($row = mysql_fetch_assoc($dbRecord)){
						echo "<option>" . $row['name'] . "</option>";
					}
				echo "</datalist>";
			
			?>
                
                
            
            <label for="item-name">Item Name</label>
            <input type="text" id="item-name" name="item-name" placeholder="Item Name" tabindex="2">
            <label for="priority">Priority</label>
            <input type="text" id="priority" name="priority" placeholder="e.g. 1" tabindex="3">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" placeholder="$1,000,000.00" tabindex="4">
            <label for="quantity">Quantity</label>
            <input type="text" id="quantity" name="quantity" placeholder="e.g. 1" tabindex="5">
            <label for="budget">Budget</label>
            <input type="text" id="budget" name="budget" placeholder="$100.00" tabindex="7">
            <input type="hidden" name="buttonval" id="buttonval">
            <input type="hidden" name="listset" id="listset">
            <div class="grd-row">
                <a id="additem" class="btn--blue grd-row-col-4-6" href="#" tabindex="6">Add Item</a>
                <a class="btn--gray grd-row-col-4-6" href="#" tabindex="8">Start Shopping</a>
            </div>
        </form>
        </div>
        
        <?php 
		if ($itemInList){
			echo "<p>Item is already in the list, not added.</p><br/>";
		}
		?>
        
    <div class="list">
    <table>
        <thead>
            <tr>
                <th>Priority</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <colgroup>
            <col width="15%"/>
            <col width="45%"/>
            <col width="15%"/>
            <col width="15%"/>
            <col width="10%"/>
        </colgroup>
        <tbody>
            
        <?php
		
			if (isset($_POST['buttonval'])){
			
				$query = "SELECT * FROM `Items` WHERE `list` = '$listid' ORDER BY `priority`";
	  			$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
			
				while($row = mysql_fetch_assoc($dbRecord)){
					echo "<tr class='item'>";
					echo "<td>" . $row['priority'] . "</td>";
					echo "<td>" . $row['item_name'] . "</td>";
					echo "<td>" . $row['cost'] . "</td>";
					echo "<td>" . $row['quantity'] . "</td>";
					echo "</tr>";
				}
			}
			
		?>
        </tbody>
    </table>
    </div>
    <div class="grd-row">
        <a class="btn--red grd-row-col-2-6" href="#">Clear List</a>
        <a class="btn--blue grd-row-col-2-6" href="#">Save List</a>
    </div>
    </div>
    
    
</body>
</html>
