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
                        $(".error-msg").text(response.error);
                    }
                    else
                    {
                        window.location.href = "dashboard.php";
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });
});