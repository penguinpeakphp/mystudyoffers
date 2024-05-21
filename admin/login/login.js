$(function()
{
    $("#loginform").on("submit" , function(e)
    {
        e.preventDefault();

        //Get the formdata
        let formdata = new FormData(this);

        //Make a post request to login controller to execute the login at the backend
        $.ajax({
            url: '../controllers/login/login.php',
            data: formdata,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) 
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        alert(response.error);
                    }
                    //If the response is successful, then redirect to dashboard
                    else
                    {
                        window.location.href = "../dashboard/dashboard.php";
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });

    $("#forgotpasswordform").on("submit" , function(e) {
        e.preventDefault();
        //Get the formdata
        let formdata = new FormData(this);
        //Make a post request to login controller to execute the login at the backend  
        $.ajax({
            url: '../controllers/login/forgotpassword.php',
            data: formdata,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) 
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);
                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        alert(response.error);
                    }
                    //If the response is successful, then redirect to dashboard
                    else
                    {
                        $("#forgotPasswordModal").modal("hide");
                        alert("Password reset link has been sent to your email");
                    }
                }   
                catch(error)
                {   
                    alert("Error occurred while trying to read server response in forgot password");
                }
            }
        });
    })

        
});