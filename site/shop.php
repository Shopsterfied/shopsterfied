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
		//If user is signed in, set username
		$userid = $_COOKIE['username'];
	  
	  	//Connect to database
	  	$dbConnected = mysql_connect("localhost", "shopsterfieduser", "hrnxUuxnT57RnZmZ")
		  	or die('Failed to connect:  '.mysql_error());
	  	mysql_select_db('shopsterfied', $dbConnected)
		  	or die('Connected but could not find database: '.mysql_error());
			
			
		//Get userid from database, assign to $ownerid	
		$query = "SELECT `id` FROM `Users` WHERE `user_name` = '$userid'";
	  	$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  	$arrRecord = mysql_fetch_row($dbRecord);
		$ownerid = $arrRecord[0];
		
		
		//Initialize variables
		$listvalue = 0;     //to represent total cost of items in the list
		$budget = 0.0;      //Budget dollar value
		$enteredBudget = 0; //to hold budget value entered by user in the input field
		
		
		//this section is executed only if a button was pressed to submit the form
		//not the first time the user navigates to this page	
		if (isset($_POST['buttonval'])){
			
			$btnmsg = $_POST['buttonval'];    //which button was pressed to submit this form
			if ($btnmsg != "shopnow"){
				$listname = $_POST['list-name'];  //get list name from form input field
			}
			else{
				$listname = "";
			}
			
			
			/*
			 *If list name was not selected by user but user
			 *had previously selected a list prior to submitting the
			 *form this time, then maintain the previous list selection
			 */
			if (trim($listname) == "" && isset($_POST['currentlist'])){
				$listname = $_POST['currentlist'];
			}
			
			
			//set variables with values from input fields
			$itemname = $_POST['item-name'];
			$quantity = $_POST['quantity'];
			$priority = $_POST['priority'];
			$price = $_POST['price'];
			
			
			//if Add Item or Start Shopping was clicked and list name is set, execute the following
			if (($btnmsg == 'addItem' || $btnmsg == 'shopnow') && trim($listname) != "") {
				
				//Get list id and list budget from database
				$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$listname' AND `owner` = '$ownerid')";
	  			$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				
				
				//if the list does not exist in the database, create it and get the new id and budget
				if (mysql_num_rows($dbRecord) == 0){
					$query = "INSERT INTO `Lists`(`name`, `owner`) VALUES ('$listname', '$ownerid')";
	  				mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$listname' AND `owner` = '$ownerid')";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				}
	  			$arrRecord = mysql_fetch_row($dbRecord);
				$listid = $arrRecord[0];
				
				
				//if budget input field has a value from user, 
				//update database with budget value and set budget variable value
				//else set budget variable with value from database
				if (isset($_POST['budget']) && $_POST['budget'] != ""){
					$enteredBudget = $_POST['budget'];
					$query = "UPDATE `Lists` SET `bank`='$enteredBudget' WHERE `id`='listid'";
	  				mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					$budget = $enteredBudget;
				}
				else{
					$budget = $arrRecord[1];
				}
				
				
				//Determine if item is already in the list
				$itemInList = False;
				$query = "SELECT `item_name` FROM `Items` WHERE `list` = '$listid'";
				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
			
				while($row = mysql_fetch_assoc($dbRecord)){
					if ($row['item_name'] == $itemname){
						$itemInList = True;
					}
				}
				
				
				//If item input values all have values, and item is not already in list,
				//and "Add Item" was selected, then add item to the database
				if ($btnmsg == 'addItem' && trim($itemname) != "" && trim($quantity) != ""
					&& trim($priority) != "" && trim($price) != "" && !$itemInList){
					$query = "INSERT INTO Items(`list`, `item_name`, `cost`, `quantity`, `priority`) 
						VALUES ('$listid','$itemname','$price','$quantity','$priority')";
					mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				}
				
				
				/*
				 *if "Start Shopping" was selected and the list exists,
				 *calculate purchased Items list, remaining items list
				 *save them both and display purchased items.
				 */
				 
				if($btnmsg == 'shopnow' && trim($listname) != ""){
					
					$purchaselist = $listname . " (items purchased)";
					$remaininglist = $listname . " (items remaining)";
					$purchaseID = 0;
					$remainingID = 0;
					
					//Check if there is an existing purchase list
					$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$purchaselist' AND `owner` = '$ownerid')";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				
				
					//if the purchase list does not exist in the database, create it and get the new id
					//else clear the existing purchase list
					if (mysql_num_rows($dbRecord) == 0){
						$query = "INSERT INTO `Lists`(`name`, `owner`) VALUES ('$purchaselist', '$ownerid')";
	  					mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
						$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$purchaselist' AND `owner` = '$ownerid')";
	  					$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  					$arrRecord = mysql_fetch_row($dbRecord);
						$purchaseID = $arrRecord[0];
					}
					else {
	  					$arrRecord = mysql_fetch_row($dbRecord);
						$purchaseID = $arrRecord[0];
						$query = "DELETE FROM `Items` WHERE `list`='$purchaseID'";
						mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					}
					
					//Check if there is an existing remaining items list
					$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$remaininglist' AND `owner` = '$ownerid')";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
				
				
					//if the remaining items list does not exist in the database, create it and get the new id
					//else clear the existing remaining items list
					if (mysql_num_rows($dbRecord) == 0){
						$query = "INSERT INTO `Lists`(`name`, `owner`) VALUES ('$remaininglist', '$ownerid')";
	  					mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
						$query = "SELECT `id`, `bank` FROM `Lists` WHERE (`name` = '$remaininglist' AND `owner` = '$ownerid')";
	  					$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
	  					$arrRecord = mysql_fetch_row($dbRecord);
						$remainingID = $arrRecord[0];
					}
					else {
	  					$arrRecord = mysql_fetch_row($dbRecord);
						$remainingID = $arrRecord[0];
						$query = "DELETE FROM `Items` WHERE `list`='$remainingID'";
						mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					}
					
					
					/*
					 *Iterate through items in the original list in priority order
					 *Adding items that fit in budget to purchase list
					 *Items that do not fit in budget are added to the remaining list
					 */
					 
					$query = "SELECT * FROM `Items` WHERE `list` = '$listid' ORDER BY `priority`";
	  				$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
			
					while($row = mysql_fetch_assoc($dbRecord)){
						$qtyPurchased = 0;
						$quantity = $row['quantity'];
						$price = $row['cost'];
						$itemname = $row['item_name'];
						$priority = $row['priority'];
						$remainingBudget = $budget;
						for ($i = 0; $i < $quantity; $i++){
							if ($price <= $remainingBudget){
								$qtyPurchased++;
								$remainingBudget = $remainingBudget - $price;
							}
						}
						
						
						
						if ($qtyPurchased > 0){
							$query = "INSERT INTO `Items`(`list`, `item_name`, `cost`, `quantity`, `priority`) VALUES ('$purchaseID','$itemname','$price','$qtyPurchased','$priority')";
							mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
						}
						
						$numRemaining = $quantity - $qtyPurchased;
						
						if (($numRemaining) > 0){
							$query = "INSERT INTO `Items`(`list`, `item_name`, `cost`, `quantity`, `priority`) VALUES ($remainingID,'$itemname','$price','$numRemaining','$priority')";
							mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
						}
					}
					
					
					//update remaining items list with remaining budget
					//set display list to purchase list
					$query = "UPDATE `Lists` SET `bank`='$remainingBudget' WHERE `id`='$remainingID'"
					mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
					$listname = $purchaselist;
					$listid = $purchaseID;
					
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
			
				//if user is signed in, indicate username, else promt user to sign in
				if (isset($_COOKIE['username'])){
					echo '<h4>Signed in as:  ' . $userid . '</h4>
					';
				}
				else {
					echo '<h4>Not signed in.  <a href="index.php">Click here</a> to sign in.</h4>
					';
				}
			
				//If list name has been input, indicate list name of the list
				//else if a list was selected previous to the current submission,
				//indicate the the name of that list
				//else prompt the user to select/create a list
				if (isset($_POST['list-name']) && $listname != ""){
					echo '<h4>Selected List:  ' . $listname . '</h4>
					';
					echo '<input type="hidden" id="currentlist" name="currentlist" value="' . $listname . '">
					';
				}
				else if (isset($_POST['$currentlist'])){
					echo '<h4>Selected List:  ' . $currentlist . '</h4>\n';
					echo '<input type="hidden" id="currentlist" name="currentlist" value="' . $currentlist . '">
					';
				}
				else {
					echo '<p>Please select a list in the dropdown below or enter a new list name, then click "Add Item"</p>
					';
				}
			?>
            
            
            <label for="list-name">Select or Create List</label>
            <input list="list-names" id="list-name" name="list-name" tabindex="1">
                
            <?php
			
					//Populate list name input dropdown with list names associated with 
					//this owner in the database
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
                <a id="shopnow" class="btn--gray grd-row-col-4-6" href="#" tabindex="8">Start Shopping</a>
            </div>
        </form>
        </div>
        
        <?php 
		
		//if the item being added is already in the list, indicate this to the user
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
		
			//if this is not the initial navigation to this form
			//get items from the list in the database and display them in the table
			//and calculate the total cost of items in the list
			if (isset($_POST['buttonval']) && $listname != ""){
			
				$query = "SELECT * FROM `Items` WHERE `list` = '$listid' ORDER BY `priority`";
	  			$dbRecord = mysql_query($query, $dbConnected) or die("Query failed: ".mysql_error());
			
				while($row = mysql_fetch_assoc($dbRecord)){
					$listvalue = $listvalue + ($row['cost'] * $row['quantity']);
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
    <?php
	
		//if listname is not empty, indicate list budget and total cost of items in list
		if ($listname != ""){
			echo '<h5>Budget = $' . number_format($budget, 2) . '</h5>
			';
			echo '<h5>Total Cost of items = $' . number_format($listvalue, 2) . '</h5>
			';
		}
	
	?>
    </div>
    <div class="grd-row">
        <a class="btn--red grd-row-col-2-6" href="#">Clear List</a>
        <a class="btn--blue grd-row-col-2-6" href="#">Save List</a>
    </div>
    </div>
    
    
</body>
</html>
