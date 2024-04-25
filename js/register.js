$(function()
{
    //Open Register modal for displaying register form
    $(".registerbutton").on("click" , function()
    {
        $("#exampleModal").modal("show");
    });

    //Make ajax call on submitting the form
    $("#studentregister").on("submit" , function(e)
    {
        e.preventDefault();

        //Validate before submitting the form if the terms and conditions are checked or not
        if(!document.getElementById('chkterms').checked)
        {
            //Display the message if terms and conditions are met
            document.getElementById('agree_chk_error').style.visibility='visible';
            return;
        }
        else
        {
            document.getElementById('agree_chk_error').style.visibility='hidden';
        }

        let formdata = new FormData(this);

        $("#register").text("REGISTERING...");
        $("#register").prop("disabled" , true);
        //Make post request for registering the student
        $.ajax({
            url: "controllers/register/registerstudent.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        $("#registermsg").text(response.error);
                    }
                    else
                    {
                        alert("Your account has been registered");
                        
                        //Reset the form
                        $("#studentregister")[0].reset();
                        window.location.href = "registrationsuccess.php?id="+response.id+"&email="+response.email+"&name="+response.name;
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        }).done(function()
        {
            $("#register").text("REGISTER");
            $("#register").prop("disabled" , false);        
        })
    });
});