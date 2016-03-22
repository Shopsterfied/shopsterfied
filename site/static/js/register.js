// JavaScript Document

$(document).ready(function(){
	
	var namepattern = /^[a-zA-Z][a-zA-Z\d]{0,39}$/;
	var passpattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,10}$/;
	var msg = "";
	
	$('#submitreg').click(function(){
		var fname = $('#first-name').val();
		if (namepattern.test(fname)){
			var lname = $('#last-name').val();
			if (namepattern.test(lname)){
				var uname = $('#user').val();
				if (namepattern.test(uname)){
					var pwrd = $('#pass').val();
					if (passpattern.test(pwrd)){
       					$('#regform').submit();
					}
					else{
						msg = "Password must be from 6 to 10 characters, may contain special characters, and must have at least one lowercase letter, at least one uppercase letter, and at least one number.";
						$('#input-msg').text(msg);
						$('#input-msg').show();
					}
				}
				else{
					msg = "User name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
					$('#input-msg').text(msg);
					$('#input-msg').show();
				}
			}
			else{
				msg = "Last name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
				$('#input-msg').text(msg);
				$('#input-msg').show();
			}
		}
		else{
			msg = "First name must start with a letter, followed by any combination of letters and/or numbers.  Minimum 1 character, maximum 40.";
			$('#input-msg').text(msg);
			$('#input-msg').show();
			}
    });
		

});
