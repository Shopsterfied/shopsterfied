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
</head>
<body>
    <header class="txt--center">
        <h1><i class="fa fa-shopping-bag"></i> Shopsterfied<h1>
    </header>
    <div class="bg--off-white py2 px2 measure content">
        <div class"form">
        <form id="shopform" action="#" role="form">
            <label for="list-name">List Name</label>
            <input list="list-names" id="list-name" name="list-name" tabindex="1">
            <datalist id="list-names">
                <option value="List1">
                <option value="List2">
                <option value="List3">
                <option value="List4">
                <option value="List5">
            </datalist>
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
            <div class="grd-row">
                <a id="additem" class="btn--blue grd-row-col-4-6" href="#" tabindex="6">Add Item</a>
                <a class="btn--gray grd-row-col-4-6" href="#" tabindex="8">Start Shopping</a>
            </div>
        </form>
        </div>
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
            <tr class="item"></tr>
        </tbody>
    </table>
    </div>
    <div class="grd-row">
        <a class="btn--red grd-row-col-2-6" href="#">Clear List</a>
        <a class="btn--blue grd-row-col-2-6" href="#">Save List</a>
    </div>
    </div>
    <!--
    < 
	if (isset($_POST['button']){
		$btnmsg = $_POST['button'];
		echo '<h3 id="msg">' . $btnmsg . ' button was pressed</h3>';
	}
	
    -->
</body>
</html>
