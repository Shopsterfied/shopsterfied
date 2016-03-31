// JavaScript Document

var listNamePattern = /^(\w{1,100})?$/;
var itemNamePattern = /^(\w{1,80})?$/;
var msg = "";

function normalizeDollars(parameter) {
	parameter.replace("$", "");
	parameter.replace(",", "");
	return parseFloat(parameter);
}


	
	
var isGoodListname = listNamePattern.test($('#list-name').val());
var isGoodItemname = itemNamePattern.test($('#item-name').val());


$(document).ready(function(){
	
	
	if (isGoodListname){
		if (isGoodItemname){
			if (!isNaN(parseInt($('#priority').val())) || $('#priority').val() == ""){
				if (!isNaN(normalizeDollars($('#price').val())) || $('#price').val() == ""){
					if (!isNaN(parseInt($('#quantity').val())) || $('#quantity').val() == ""){
						if (!isNaN(normalizeDollars($('#budget').val())) || $('#budget').val() == ""){
							
							//If Add Item/Update List was clicked
							$('#additem').click(function(){
								$('#buttonval').val('addItem');
								$('#shopform').submit();
								
							});
							
							//If start shopping was clicked
							$('#shopnow').click(function(){
								$('#buttonval').val('shopnow');
								$('#shopform').submit();
								
							});
							
							//If Clear List was clicked
							$('#clear').click(function(){
								if (confirm("You have chosen to clear and delete this list.  Are you sure?")){
									$('#buttonval').val('clear');
									$('#shopform').submit();
								}
							});
							
						}
						else{
							msg = "Budget input is invalid";
							$('#input-msg').text(msg);
							$('#input-msg').show();
						}
					}
					else{
						msg = "Quantity input is invalid";
						$('#input-msg').text(msg);
						$('#input-msg').show();
					}
				}
				else {
					msg = "Price input is invalid";
					$('#input-msg').text(msg);
					$('#input-msg').show();
				}
			}
			else {
				msg = "Priority input is invalid";
				$('#input-msg').text(msg);
				$('#input-msg').show();
			}
		}
		else {
			msg = "Item name input is invalid";
			$('#input-msg').text(msg);
			$('#input-msg').show();
		}
	}
	else {
		msg = "List name input is invalid";
		$('#input-msg').text(msg);
		$('#input-msg').show();
	}
});