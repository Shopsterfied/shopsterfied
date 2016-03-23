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
	
	//$(document).on('input', '#list-names', function() {
	$('#list-names').change(function(){
		$('#buttonval').val('listset');
		$('#shopform').submit();
		});

});