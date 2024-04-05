function registrationform_check(){

	var form = document.studentregi;

	var emailvalid  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(form.stemail.value == "") 
	{
		alert('Please Enter Email id');
		form.stemail.focus();
		return false;
	}
	else if(!emailvalid.test(form.stemail.value))
	{
		alert('Plaese Enter Valid Email Id!');
		form.stemail.focus();
		return false;
	}
   

    if(!document.getElementById('chkterms').checked)
    {
        document.getElementById('agree_chk_error').style.visibility='visible';
        return false;
    }
    else
    {
        document.getElementById('agree_chk_error').style.visibility='hidden';
        return true;
    }


	/*if(form.chkterms.checked==false)
	{
		alert('You must agree to Terms and Conditions!');
		form.chkterms.focus();
		return.false;
	}*/

}
