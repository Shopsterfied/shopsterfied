// JavaScript Document

$(document).ready(function(){
	
	var namepattern = /^[a-zA-Z][a-zA-Z\d]{0,39}$/;
	var passpattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,10}$/;
	var msg = "";
	
	$('#first-name').change(function(){
		var fname = $('#first-name').val();
		if (fname.test(namepattern)){
			msg = "First name OK...";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
		else {
			msg = "First name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
	});
		
	$('#last-name').change(function(){
		var lname = $('#last-name').val();
		if (lname.test(namepattern)){
			msg = "Last name OK...";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
		else {
			msg = "Last name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
	});
	
	$('#user').change(function(){
		var uname = $('#user').val();
		if (uname.test(namepattern)){
			msg = "User name OK...";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
		else {
			msg = "Last name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
	});
	
	$('#pass').change(function(){
		var pwrd = $('#pass').val();
		if (pwrd.test(passpattern)){
			msg = "Password OK...";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
		else {
			msg = "Password must be from 6 to 10 characters, may contain special characters, and must have at least one lowercase letter, at least one uppercase letter, and at least one number.";
			$('#input-msg').val(msg);
			$('#input-msg').show();
		}
	});
	
	$('#submitreg').click(function(){
        document.forms.namedItem('regform').submit();
    });
		

});