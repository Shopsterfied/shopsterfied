// JavaScript Document

$(document).ready(function(){
    $('#additem').click(function(){
        var data = $('#shopform').serializeArray();
        data.push({name: 'button', value: 'additem'});
		console.log( data );
  		event.preventDefault()

        //$.post("shop.php", data);
		
	});

});