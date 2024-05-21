$(function()
{

    $("#resetpasswordform").on("submit" , function(e)
    {
        e.preventDefault();
        let formdata = new FormData(this);

        // ectracting adminemail and token from the get parameters using URLSearchParams
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const email = urlParams.get('adminemail');
        const token = urlParams.get('token');

        //Get the formdata
        formdata.append("adminemail", email);
        formdata.append("token", token);

        //Make a post request to login controller to execute the login at the backend
        $.ajax({
            url: '../controllers/login/resetpassword.php',
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
                        alert("Password reset successfully");
                        window.location.href = "../login/login.php";
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        })
    })
})