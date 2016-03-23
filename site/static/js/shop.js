// JavaScript Document

$(document).ready(function(){
    $('#additem').click(function(){
        var data = $('#shopform').serializeArray();
        data.push({name: 'button', value: 'addItem'});

        $.post("shop.php", data);
		
	});

});