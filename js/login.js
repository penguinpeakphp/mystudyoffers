$(function()
{
    $("#loginform").on("submit" , function(e)
    {
        e.preventDefault();

        //Create the form data instance for submitting
        let formdata = new FormData(this);

        //Make the ajax call for logging in
        $.ajax({
            url: "controllers/login/loginstudent.php",
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
                        showalert(response.error)
                    }
                    else
                    {
                        window.location.href = response.url;
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });

    $("#forgotPassword").on("click", function()
    {
        $("#forgotPasswordModal").modal("show");
    });

    $("#forgotPasswordForm").on("submit", function(e)
    {
        e.preventDefault();
        let formdata = new FormData(this);
        $.ajax({
            url: "controllers/forgotpassword/forgotpassword.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data)
            {
                console.log(data);
                return;
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        showalert(response.error);
                    }
                    else
                    {
                        showalert("Password reset link has been sent to your email address");
                    }
                }   
                catch(error)    
                {
                    alert("Error occurred while trying to read server response");
                }   
            },
            always: function()
            {
                $("#forgotPasswordModal").modal("hide");
            }
        });
    });
});