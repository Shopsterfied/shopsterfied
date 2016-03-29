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
	
	
    $('#shopnow').click(function(){
		$('#buttonval').val('shopnow');
		$('#shopform').submit();
		
	});
	
	$('#clear').click(function(){
		if (confirm("You have chosen to clear and delete this list.  Are you sure?")){
		}
	});

});