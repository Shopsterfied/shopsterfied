<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopsterfied</title>
    <link rel="stylesheet" href="static/css/furtive.css">
    <link rel="stylesheet" href="static/css/font-awesome.css">
    <link rel="stylesheet" href="static/css/site.css">
</head>
<body>
    <div class="bg--off-white py2 measure">
        <div class="txt--center">
            <h1><i class="fa fa-shopping-bag"></i> Shopsterfied<h1>
        </div>

    <form class="px2" action="#" role="form">
        <label for="item-name">Item Name</label>
        <input type="text" id="item-name" name="item-name" placeholder="Item Name">
        <label for="priority">Priority</label>
        <input type="text" id="priority" name="priority" placeholder="e.g. 1">
        <label for="price">Price</label>
        <input type="text" id="price" name="price" placeholder="$1,000,000.00">
        <label for="quantity">Quantity</label>
        <input type="text" id="quantity" name="quantity" placeholder="e.g. 1">
        <label for="budget">Budget</label>
        <input type="text" id="budget" name="budget" placeholder="$100.00">
        <div class="grd-row">
            <a class="btn--gray grd-row-col-4-6" href="#">Start Shopping</a>
        </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Priority</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="grd-row">
        <a class="btn--red grd-row-col-2-6" href="#">Clear</a>
        <a class="btn--blue grd-row-col-2-6" href="#">Save</a>
    </div>
    </div>
</body>
</html>
