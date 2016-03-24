// JavaScript Document

function validateListName(listname){
	
	var listNamePattern = /$\w{1,40}$/;
	return listNamePattern.test(listname);
}



$(document).ready(function(){
    $('#additem').click(function(){
		$('#buttonval').val('addItem');
		$('#shopform').submit();
		
	});

});